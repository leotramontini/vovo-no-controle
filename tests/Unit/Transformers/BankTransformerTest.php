<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use Vovo\Models\Bank;
use Vovo\Transformer\BankTransformer;

class BankTransformerTest extends TestCase
{
    protected $transformer;
    protected $bank;

    public function setUp(): void
    {
        parent::setUp();
        $this->bank = factory(Bank::class)->create();

        $this->transformer = new BankTransformer();
    }

    public function testTransform()
    {
        $expected = [
            'id'    => $this->bank->id,
            'name'  => $this->bank->name
        ];

        $this->assertEquals($expected, $this->transformer->transform($this->bank));
    }
}
