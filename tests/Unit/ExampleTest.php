<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Act;
use App\Priority;

class ExampleTest extends TestCase
{

	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

    	$first = factory(Priority::class)->create();

    	$second = factory(Priority::class)->create([
    		'created_at' => \Carbon\Carbon::now()->subMonth()

    	]);

    	$priorities = Priority::all()->toArray();

    	// dd($priorities);
        
    	// Act::idAndName();

        // $this->assertTrue(true);

        // $this->assertCount(2, $priorities);

        $this->assertEquals([
        	[	
        		'id' => $first->id,
        		'user_id' => $first->user_id,
        		'name' => $first->name,
        		'created_at' => $first->created_at,
        		'updated_at' => $first->updated_at,
        	],
        	[	
        		'id' => $second->id,
        		'user_id' => $second->user_id,
        		'name' => $second->name,
        		'created_at' => $second->created_at,
        		'updated_at' => $second->updated_at,
        	]

        ], $priorities);
    }
}
