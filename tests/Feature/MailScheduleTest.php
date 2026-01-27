<?php

namespace Tests\Feature;

use App\Models\MailContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMailSchedule()
    {
        // 创建一个 mail_contents 表的测试数据
        $mailContent = MailContent::factory()->create();

        $data = [
            "sender_name" => "dolor in aute",
            "name" => "occaecat",
            "reply" => "wG00ujDQ03@XbJRiVGThx.ine",
            "mail_id" => $mailContent->id,
            "processed_at" => "2022-08-02T04:41:54.334Z",
            "type" => -56385750,
            "receives" => [
                "u-r@vligMfjCjywzQFNQUHovxyFcv.hva",
                "k7fcwSOY8I@llKIgRDqIgTVyEaOKv.zvti",
                "xMoD64abGr@eAOAETUuqHmTfrWiKrxQeigfEKHs.wme"
            ],
            "sku" => "qui tempor nulla in",
            "score_code" => "commodo aliquip Duis Lorem",
            "mark" => "dolore in tempor adipisicing"
        ];

        $response = $this->post('/api/mail-schedule/store', $data, [
            'Accept' => 'application/json',
            'User-Agent' => 'Apifox/1.0.0 (https://www.apifox.cn)',
            'Content-Type' => 'application/json',
            'ts' => '1679284537',
            'uc' => 'software',
            'un' => '15626202843',
            'st' => '3fc0a8abc637d7d85a69b61b5906fff9'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
                                  // Your expected JSON response goes here
                              ]);
    }
}
