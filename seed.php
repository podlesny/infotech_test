<?php

require_once 'bootstrap.php';

use App\Key;
use App\Action;
use App\RequiredObject;
use App\Step;

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
	'text' => 'Вы увидели шкаф с двумя ящиками. Какой откроете?'
]);

Action::create([
	'text' => 'Осмотреться',
	'prev_id' => $chairFree->id,
	'next_id' => $locker->id
]);

$descent = Step::create([
	'text' => 'Вы вышли из комнаты и пришли к лестничной клетке. Нужно спуститься вниз. Что выберете?'
]);

$key = Step::create([
	'text' => 'В ящике найден ключ.'
]);

$scrap = Step::create([
	'text' => 'В ящике найден лом.'
]);

$upperBox = Action::create([
	'text' => 'Открыть верхний ящик',
	'prev_id' => $locker->id,
	'next_id' => $key->id
]);

$lowerBox = Action::create([
	'text' => 'Открыть нижний ящик',
	'prev_id' => $locker->id,
	'next_id' => $scrap->id
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $key->id,
	'next_id' => $descent->id
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $scrap->id,
	'next_id' => $descent->id
]);

Action::create([
	'text' => 'Выйти из комнаты',
	'prev_id' => $locker->id,
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

RequiredObject::create([
	'fail_text' => 'Ступеньки оказались слишком старые и обвалились. Вы мертвы.',
	'random' => true,
	'death' => true,
	'found_step_id' => $downStairs->id,
	'required_step_id' => $downStairs->id,
	'redirect_step_id' => $begin->id
]);

RequiredObject::create([
	'fail_text' => 'В лифте оборвался трос. Вы мертвы.',
	'random' => true,
	'death' => true,
	'found_step_id' => $downLift->id,
	'required_step_id' => $downLift->id,
	'redirect_step_id' => $begin->id
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

RequiredObject::create([
	'pass_text' => 'Вы открыли дверь ключом.',
	'fail_text' => 'У вас нет предметов чтобы открыть эту дверь. Надо вернуться назад в комнату.',
	'exists_text' => 'Ключ вы уже взяли, ящик пустой',
	'found_step_id' => $key->id,
	'required_step_id' => $corridor->id,
	'redirect_step_id' => $locker->id
]);

RequiredObject::create([
	'pass_text' => 'Вы взломали дверь ломом.',
	'fail_text' => 'У вас нет предметов чтобы открыть эту дверь. Надо вернуться назад в комнату.',
	'exists_text' => 'Лом вы уже взяли, ящик пустой',
	'found_step_id' => $scrap->id,
	'required_step_id' => $corridor->id,
	'redirect_step_id' => $locker->id
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
	'next_id' => $deadEnd->id,
]);

$rightSide = Action::create([
	'text' => 'Направо',
	'prev_id' => $corridor->id,
	'next_id' => $exit->id,
]);

$goBack = Action::create([
	'text' => 'Вернуться назад',
	'prev_id' => $deadEnd->id,
	'next_id' => $corridor->id,
]);

$victory = Step::create([
	'text' => ''
]);

RequiredObject::create([
	'pass_text' => 'Охранник в вас выстрелил, но вы в бронежилете. На секунду он потерял бдительность, вы отобрали пистолет и выстрелили в него.',
	'fail_text' => 'Вы нападаете на охранника, но у вас нет оружия и средств защиты, он вас застрелил. Вы мертвы.',
	'exists_text' => 'Бронежилет вы уже взяли, тут пусто.',
	'death' => true,
	'found_step_id' => $deadEnd->id,
	'required_step_id' => $victory->id,
	'redirect_step_id' => $begin->id
]);

RequiredObject::create([
	'pass_text' => 'Вы незаметно подкрались сзади и оглушили охранника ломом.',
	'fail_text' => 'Вы нападаете на охранника, но у вас нет оружия и средств защиты, он вас застрелил. Вы мертвы.',
	'exists_text' => 'Лом вы уже взяли, ящик пустой',
	'death' => true,
	'found_step_id' => $lowerBox->id,
	'required_step_id' => $victory->id,
	'redirect_step_id' => $begin->id
]);

$freedom = Step::create([
	'text' => 'Вы убежали. Недалеко оказалась трасса, вы остановили машину и уехали подальше отсюда. Вы свободны.'
]);

Action::create([
	'text' => 'Бежать отсюда.',
	'prev_id' => $victory->id,
	'next_id' => $freedom->id,
]);