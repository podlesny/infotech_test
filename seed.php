<?php

require_once 'bootstrap.php';

use App\Action;
use App\Thing;
use App\Step;
use App\Trap;

$begin = Step::create([
	'text' => 'Вы находитесь в заброшенном помещении, привязаны к креслу. Вы не знаете где вы и как тут оказались, но точно пора отсюда выбираться.',
	'begin' => true
]);

$shot = Step::create([
	'text' => 'Вас услышали, в комнату заходит вооруженный человек в маске и стреляет в вас. Вы мертвы.',
]);

Action::create([
	'text' => 'Кричать, звать на помощь',
	'prev_id' => $begin->id,
	'next_id' => $shot->id
]);

$chairFree = Step::create([
	'text' => 'Кресло упало на пол и развалилось. Вы свободны.',
]);

Action::create([
	'text' => 'Попытаться раскачать кресло',
	'prev_id' => $begin->id,
	'next_id' => $chairFree->id
]);

$locker = Step::create([
	'text' => 'Вы увидели шкаф с двумя ящиками. Что выберете?'
]);

Action::create([
	'text' => 'Осмотреться',
	'prev_id' => $chairFree->id,
	'next_id' => $locker->id
]);

$descent = Step::create([
	'text' => 'Вы вышли из комнаты и пришли к лестничной клетке. Нужно спуститься вниз. Что выберете?'
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $locker->id,
	'next_id' => $descent->id
]);

$keyFound = Step::create([
	'text' => 'В ящике найден ключ.'
]);

$scrapFound = Step::create([
	'text' => 'В ящике найден лом.'
]);

$upperBox = Action::create([
	'text' => 'Открыть верхний ящик',
	'prev_id' => $locker->id,
	'next_id' => $keyFound->id
]);

$lowerBox = Action::create([
	'text' => 'Открыть нижний ящик',
	'prev_id' => $locker->id,
	'next_id' => $scrapFound->id
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $keyFound->id,
	'next_id' => $descent->id
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $scrapFound->id,
	'next_id' => $descent->id
]);


$downStairs = Step::create([
	'text' => 'Вы спустились вниз.'
]);

$downLift = Step::create([
	'text' => 'Вы спустились вниз.'
]);

$stairs = Action::create([
	'text' => 'Спуститься по ступенькам',
	'prev_id' => $descent->id,
	'next_id' => $downStairs->id,
]);

$lift = Action::create([
	'text' => 'Воспользоваться лифтом',
	'prev_id' => $descent->id,
	'next_id' => $downLift->id,
]);

$door = Step::create([
	'text' => 'Впереди вы видите закрытую дверь.'
]);

Action::create([
	'text' => 'Идти дальше',
	'prev_id' => $downStairs->id,
	'next_id' => $door->id
]);

Action::create([
	'text' => 'Идти дальше',
	'prev_id' => $downLift->id,
	'next_id' => $door->id
]);

$corridor = Step::create([
	'text' => 'Дверь ведет в коридор. В какую сторону пойдете?'
]);

Action::create([
	'text' => 'Открыть дверь',
	'prev_id' => $door->id,
	'next_id' => $corridor->id
]);

$exit = Step::create([
	'text' => 'Вы нашли выход, но его охраняет вооруженный человек в маске.'
]);

$deadEnd = Step::create([
	'text' => 'Вы уперлись в тупик, но по пути нашли бронежилет.'
]);

$leftSide = Action::create([
	'text' => 'Налево',
	'prev_id' => $corridor->id,
	'next_id' => $exit->id,
]);

$rightSide = Action::create([
	'text' => 'Направо',
	'prev_id' => $corridor->id,
	'next_id' => $deadEnd->id,
]);

$goBack = Action::create([
	'text' => 'Вернуться назад',
	'prev_id' => $deadEnd->id,
	'next_id' => $corridor->id,
]);

$victory = Step::create([
	'text' => ''
]);

Action::create([
	'text' => 'Сражаться',
	'prev_id' => $exit->id,
	'next_id' => $victory->id,
]);

$freedom = Step::create([
	'text' => 'Вы убежали. Недалеко оказалась трасса, вы остановили машину и уехали подальше отсюда. Вы свободны.'
]);

Action::create([
	'text' => 'Бежать отсюда',
	'prev_id' => $victory->id,
	'next_id' => $freedom->id,
]);

/**
 * $keyThing = Thing::create([
 * name
 * exists_text
 * found_step_id
 * random
 * ])
 * $keyThing->attach($corridor->id, [
 * pass_text
 * fail_text
 * redirect_step_id
 * death
 * ])
 * required_step_id' => $corridor->id, redirect_step_id' => $locker->id
 */

$key = Thing::create([
	'name' => 'Ключ',
	'exists_text' => 'Ключ вы уже взяли, ящик пустой',
	'found_step_id' => $keyFound->id
]);

$key->steps()->attach($corridor, [
	'pass_text' => 'Вы открыли дверь ключом.',
	'fail_text' => 'У вас нет предметов чтобы открыть эту дверь. Надо вернуться назад в комнату.',
	'redirect_step_id' => $locker->id,
]);

$scrap = Thing::create([
	'name' => 'Лом',
	'exists_text' => 'Лом вы уже взяли, ящик пустой',
	'found_step_id' => $scrapFound->id
]);

$scrap->steps()->attach($corridor, [
	'pass_text' => 'Вы взломали дверь ломом.',
	'fail_text' => 'У вас нет предметов чтобы открыть эту дверь. Надо вернуться назад в комнату.',
	'redirect_step_id' => $locker->id,
]);

$scrap->steps()->attach($victory, [
	'death' => true,
	'pass_text' => 'Вы незаметно подкрались сзади и оглушили охранника ломом.',
	'fail_text' => 'Вы нападаете на охранника, но у вас нет оружия и средств защиты, он вас застрелил. Вы мертвы.',
]);

$trapStairs = Trap::create([
	'name' => 'Ловушка на ступеньках',
	'step_id' => $downStairs->id,
	'fail_text' => 'Ступеньки оказались слишком старые и обвалились. Вы мертвы.',
]);

$trapStairs = Trap::create([
	'name' => 'Ловушка в лифте',
	'step_id' => $downLift->id,
	'fail_text' => 'В лифте оборвался трос. Вы мертвы.',
]);

// $trapStairs = Thing::create([
// 	'name' => 'Ловушка на ступеньках',
// 	'random' => true,
// 	'found_step_id' => $downStairs->id,
// ]);

// $trapStairs->steps()->attach($downStairs, [
// 	'death' => true,
// 	'fail_text' => 'Ступеньки оказались слишком старые и обвалились. Вы мертвы.',
// ]);

// $trapLift = Thing::create([
// 	'name' => 'Ловушка в лифте',
// 	'random' => true,
// 	'found_step_id' => $downLift->id,
// ]);

// $trapLift->steps()->attach($downLift, [
// 	'death' => true,
// 	'fail_text' => 'В лифте оборвался трос. Вы мертвы.',
// ]);

$scrap = Thing::create([
	'name' => 'Бронежилет',
	'exists_text' => 'Бронежилет вы уже взяли, тут пусто.',
	'found_step_id' => $deadEnd->id
]);

$scrap->steps()->attach($victory, [
	'death' => true,
	'pass_text' => 'Охранник в вас выстрелил, но вы в бронежилете. На секунду он потерял бдительность, вы отобрали пистолет и выстрелили в него.',
	'fail_text' => 'Вы нападаете на охранника, но у вас нет оружия и средств защиты, он вас застрелил. Вы мертвы.',
]);