<?php

namespace Tests\Feature;

use App\Models\Room;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function room_can_be_added_to_the_hotel(){
        $this->withoutExceptionHandling();
        $response = $this->post('/rooms',[
            'title' => 'Single Room',
            'price' => '250',
        ]);
        $response->assertOk();
        $this->assertCount(1,Room::all());
    }
    /** @test */
    public function a_title_is_required(){
        $response = $this->post('/rooms',[
            'title' => '',
            'price' => '250',
        ]);
        $response->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_price_is_required(){
        $response = $this->post('/rooms',[
            'title' => 'Single Room',
            'price' => '',
        ]);
        $response->assertSessionHasErrors('price');
    }
    /** @test */
    public function a_book_can_be_updated(){
        $this->withoutExceptionHandling();
        $this->post('/rooms',[
            'title' => 'Single Room',
            'price' => '250',
        ]);
        $room = Room::first();
        $response = $this->patch('/rooms/'.$room->id,[
            'title' => 'Double Room',
            'price' => '400',
        ]);

        $this->assertEquals('Double Room', Room::first()->title);
        $this->assertEquals('400', Room::first()->price);
    }
}
