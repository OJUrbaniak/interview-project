<?php

namespace Tests\Feature;

use App\Repositories\PropertyRepository;
use Tests\TestCase;

class PropertyRepositoryTest extends TestCase
{
    public PropertyRepository $propertyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->propertyRepository = new PropertyRepository();
    }

    public function testGetAllPropertiesReturnsAll(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getAllProperties();
        self::assertSame(5, count($res));
    }

    public function testGetPropertiesWithFilterReturnsOne(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getPropertiesWithFilter(
            '%Wales%',
            true,
            true,
            5,
            4
        );
        self::assertSame(1, count($res));
    }

    public function testGetAvailablePropertyWithFilterDateReturnsOne(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getPropertiesWithFilter(
            '%Wales%',
            true,
            true,
            5,
            4,
            '2024-01-01',
            '2024-02-01'
        );
        self::assertSame(1, count($res));
    }

    public function testGetBuysPropertyWithFilterDateReturnsNone(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getPropertiesWithFilter(
            '%Cornwall%',
            true,
            true,
            1,
            1,
            '2020-08-06',
            '2020-12-12'
        );
        self::assertSame(0, count($res));
    }

    public function testGetPropertiesWithInvalidFilterReturnsNone(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getPropertiesWithFilter(
            '%Wales%',
            true,
            true,
            5,
            20
        );
        self::assertSame(0, count($res));
    }

    public function testGetPropertiesWithUnavailableDateReturnsNone(): void
    {
//        In a real world scenario you would want to mock the DB
        $res = $this->propertyRepository->getPropertiesWithFilter(
            '%Wales%',
            true,
            true,
            5,
            20
        );
        self::assertSame(0, count($res));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}