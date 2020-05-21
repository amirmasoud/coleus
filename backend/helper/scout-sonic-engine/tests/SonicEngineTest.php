<?php

namespace Coleus\Sonic\Tests;

use stdClass;
use Mockery;
use Laravel\Scout\Builder;
use Coleus\Sonic\SonicEngine;
use PHPUnit\Framework\TestCase;
use SonicSearch\ChannelFactory;
use SonicSearch\IngestChannel;
use SonicSearch\SearchChannel;
use SonicSearch\ControlChannel;
use Illuminate\Database\Eloquent\Collection;
use Coleus\Sonic\Tests\Fixtures\ExampleModel;

class SonicEngineTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    private function mockFactory()
    {
        $ingest = Mockery::mock(IngestChannel::class);
        $ingest->shouldReceive('connect')->withNoArgs()->once();
        $ingest->shouldReceive('quit')->withNoArgs()->once();

        $search = Mockery::mock(SearchChannel::class);
        $search->shouldReceive('connect')->withNoArgs()->once();
        $search->shouldReceive('quit')->withNoArgs()->once();

        $control = Mockery::mock(ControlChannel::class);
        $control->shouldReceive('connect')->withNoArgs()->once();
        $control->shouldReceive('quit')->withNoArgs()->once();

        return [
            'ingest' => $ingest,
            'search' => $search,
            'control' => $control,
        ];
    }

    /** @test */
    public function itCanCreateTheClient()
    {
        $mocks = $this->mockFactory();

        $mocks['ingest']->shouldReceive('ping')->withNoArgs()->once();
        $mocks['ingest']->shouldReceive('push')->once();
        $mocks['control']->shouldReceive('consolidate')->withNoArgs()->once();

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $engine = new SonicEngine($factory);
        $engine->update(Collection::make([new ExampleModel(['id' => 1])]));
    }

    /** @test */
    public function itCanAddObjectsToTheIndex()
    {
        $mocks = $this->mockFactory();

        $mocks['ingest']->shouldReceive('ping')->withNoArgs()->once();
        $mocks['ingest']->shouldReceive('push')->withArgs(function () {
            $args = func_get_args();
            $expected = [
                'ExampleModels',
                'ExampleModel',
                '1',
                '1 searchable model',
            ];

            return $args == $expected;
        });

        $mocks['control']->shouldReceive('consolidate')->withNoArgs()->once();

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $engine = new SonicEngine($factory);
        $engine->update(Collection::make([new ExampleModel(['id' => 1])]));
    }

    /** @test */
    public function itCanDeleteObjectsFromTheIndex()
    {
        $mocks = $this->mockFactory();

        $mocks['ingest']->shouldReceive('ping')->withNoArgs()->once();
        $mocks['ingest']->shouldReceive('flush')->withArgs(function () {
            $args = func_get_args();
            $expected = [
                'ExampleModels',
                'ExampleModel',
                '1',
            ];

            return $args == $expected;
        });

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $engine = new SonicEngine($factory);
        $engine->delete(Collection::make([new ExampleModel(['id' => 1])]));
    }

    /** @test */
    public function itCanSearchTheIndex()
    {
        $mocks = $this->mockFactory();

        $mocks['search']->shouldReceive('ping')->withNoArgs()->once();

        $mocks['search']->shouldReceive('query')->withArgs(function () {
            $args = func_get_args();
            $expected = [
                'ExampleModels',
                'ExampleModel',
                'searchable',
                null,
                null,
            ];

            return $args == $expected;
        });

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $engine = new SonicEngine($factory);

        $builder = new Builder(new ExampleModel, 'searchable');
        $engine->search($builder);
    }

    /** @test */
    public function itCanMapCorrectlyToTheModels()
    {
        $mocks = $this->mockFactory();

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $engine = new SonicEngine($factory);

        $model = Mockery::mock(stdClass::class);
        $model->shouldReceive('getScoutModelsByIds')->andReturn($models = Collection::make([
            new ExampleModel(['id' => 1]),
        ]));
        $builder = Mockery::mock(Builder::class);
        $results = $engine->map($builder, [1], $model);
        $this->assertEquals(1, count($results));
    }

    /** @test */
    public function itCanHandleDefaultSearchableArray()
    {
        $mocks = $this->mockFactory();

        $mocks['ingest']->shouldReceive('ping')->withNoArgs()->once();
        $mocks['ingest']->shouldReceive('push')->withArgs(function () {
            $args = func_get_args();
            $expected = [
                str_plural($args[0]), // inject mockery class details
                $args[1], // inject mockery class details
                '1',
                '1 hello@example.com'
            ];

            return $args == $expected;
        });

        $mocks['control']->shouldReceive('consolidate')->withNoArgs()->once();

        $factory = Mockery::mock(ChannelFactory::class, [
            'newIngestChannel' => $mocks['ingest'],
            'newSearchChannel' => $mocks['search'],
            'newControlChannel' => $mocks['control'],
        ]);

        $model = Mockery::mock(stdClass::class);
        $model->shouldReceive('getScoutKey')->andReturn(1);
        $model->shouldReceive('toSearchableArray')->andReturn(['id' => 1, 'email' => 'hello@example.com']);

        $engine = new SonicEngine($factory);
        $engine->update(Collection::make([$model]));
    }
}
