<?php

namespace Tests\Feature;

use App\Mail\ReportMail;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReportWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Kavitha',
            'last_name' => 'S',
            'email' => 'kavitha@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'kavitha@example.com', 'role' => 'user']);
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_user_can_create_and_save_report_with_pending_status(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post('/reports', [
            'p1_first_name' => 'Vijay',
            'p1_last_name' => 'Sethupathi',
            'p1_dob' => '1985-01-16',
            'p2_first_name' => 'Trisha',
            'p2_last_name' => 'Krishnan',
            'p2_dob' => '1987-05-04',
        ]);

        $report = Report::first();
        $this->assertNotNull($report);
        $this->assertEquals('pending', $report->status);
        $this->assertEquals($user->id, $report->user_id);
        $response->assertRedirect(route('reports.show', $report));
    }

    public function test_non_approved_report_cannot_be_sent_via_email(): void
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'user']);
        $report = Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Vijay',
            'p1_last_name' => 'S',
            'p1_dob' => '1985-01-16',
            'p1_life_path' => 4,
            'p1_destiny' => 7,
            'p1_soul' => 1,
            'p1_personality' => 6,
            'p2_first_name' => 'Trisha',
            'p2_last_name' => 'K',
            'p2_dob' => '1987-05-04',
            'p2_life_path' => 7,
            'p2_destiny' => 5,
            'p2_soul' => 9,
            'p2_personality' => 5,
            'compatibility_score' => 80,
            'summary_en' => 'Great compatibility.',
            'summary_ta' => 'சிறந்த பொருத்தம்.',
            'status' => 'pending', // Pending, NOT approved
        ]);

        $response = $this->actingAs($user)->post(route('reports.email', $report));
        
        $response->assertSessionHas('error');
        Mail::assertNothingSent();
    }

    public function test_approved_report_can_be_sent_via_email(): void
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'user']);
        $report = Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Vijay',
            'p1_last_name' => 'S',
            'p1_dob' => '1985-01-16',
            'p1_life_path' => 4,
            'p1_destiny' => 7,
            'p1_soul' => 1,
            'p1_personality' => 6,
            'p2_first_name' => 'Trisha',
            'p2_last_name' => 'K',
            'p2_dob' => '1987-05-04',
            'p2_life_path' => 7,
            'p2_destiny' => 5,
            'p2_soul' => 9,
            'p2_personality' => 5,
            'compatibility_score' => 80,
            'summary_en' => 'Great compatibility.',
            'summary_ta' => 'சிறந்த பொருத்தம்.',
            'status' => 'approved', // Approved by admin
        ]);

        $response = $this->actingAs($user)->post(route('reports.email', $report));

        $response->assertSessionHas('success');
        Mail::assertSent(ReportMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        $this->assertEquals('emailed', $report->fresh()->status);
    }

    public function test_admin_can_approve_and_send_email_directly(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user', 'email' => 'client@example.com']);
        $report = Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Vijay',
            'p1_last_name' => 'S',
            'p1_dob' => '1985-01-16',
            'p1_life_path' => 4,
            'p1_destiny' => 7,
            'p1_soul' => 1,
            'p1_personality' => 6,
            'p2_first_name' => 'Trisha',
            'p2_last_name' => 'K',
            'p2_dob' => '1987-05-04',
            'p2_life_path' => 7,
            'p2_destiny' => 5,
            'p2_soul' => 9,
            'p2_personality' => 5,
            'compatibility_score' => 80,
            'summary_en' => 'Great compatibility.',
            'summary_ta' => 'சிறந்த பொருத்தம்.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.reports.approve_email', $report));

        $response->assertRedirect(route('admin.reports.index', ['status' => 'pending']));
        Mail::assertSent(ReportMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        $this->assertEquals('emailed', $report->fresh()->status);
    }

    public function test_pdf_endpoint_generates_valid_pdf_for_owner(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $report = Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Arun',
            'p1_last_name' => 'Kumar',
            'p1_dob' => '1992-06-12',
            'p1_life_path' => 3,
            'p1_destiny' => 1,
            'p1_soul' => 8,
            'p1_personality' => 2,
            'p2_first_name' => 'Priya',
            'p2_last_name' => 'Raman',
            'p2_dob' => '1995-11-18',
            'p2_life_path' => 9,
            'p2_destiny' => 6,
            'p2_soul' => 1,
            'p2_personality' => 5,
            'compatibility_score' => 78,
            'summary_en' => 'Good compatibility match.',
            'summary_ta' => 'நல்ல பொருத்தம்.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('reports.pdf', $report));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
    }
}
