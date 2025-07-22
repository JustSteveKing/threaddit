<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->strict();

arch()->expect('App')->toUseStrictTypes()->not->toUse(['die', 'dd', 'dump']);
arch()->expect('Threaddit')->toUseStrictTypes()->not->toUse(['die', 'dd', 'dump']);

arch()->expect('App\Http\Controllers')->toBeInvokable();

arch()->expect('App')->classes()->toBeFinal();
arch()->expect('Threaddit')->classes()->toBeFinal();

arch()->expect('Threaddit\Domains\*\DataObjects')->toBeReadonly();
