<?php

namespace Tests\Feature\Models;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_campaign_via_factory(): void
    {
        $campaign = Campaign::factory()->create([
            'brief' => 'Byomkesh S9, dark & mysterious, from 10 Oct',
        ]);

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'brief' => 'Byomkesh S9, dark & mysterious, from 10 Oct',
        ]);

        $this->assertNotNull($campaign->instagramImageUrl);
        $this->assertNotNull($campaign->youtubeImageUrl);
        $this->assertNotNull($campaign->xImageUrl);
        $this->assertIsArray($campaign->instagram_hashtags);
    }
}
