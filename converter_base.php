<?php
/**
 * Created by PhpStorm.
 * User: svk
 * Date: 12.12.2015
 * Time: 0:34
 */
$schema = [
	'LogEventName' => [
		[ 0, 'Въезд по билету' ],
		[ 1, 'Въезд по карте' ],
		[ 3, 'Затор на въезде' ],
		[ 4, 'Выезд по билету' ],
		[ 5, 'Выезд по карте' ],
		[ 9, 'Затор на выезде' ],
		[ 11, 'Отказ в проезде: документ не оплачен' ],
		[ 12, 'Отказ в проезде: документ не зарегистрирован' ],
		[ 13, 'Отказ в проезде: абонемент просрочен' ],
		[ 14, 'Отказ в проезде: карта уже на стоянке' ],
		[ 15, 'Отказ в проезде: въезд не зарегистрирован' ],
		[ 16, 'Оплата билета' ],
		[ 20, 'Регистрация карты' ],
		[ 23, 'Продление карты' ],
		[ 24, 'Удаление карты' ],
		[ 27, 'Пробитие чека' ],
		[ 29, 'Запуск системы' ],
		[ 30, 'Выключение системы' ],
		[ 31, 'Вход оператора' ],
		[ 32, 'Выход оператора' ],
		[ 33, 'Блокировка станции' ],
		[ 36, 'Попытка несанкционированного доступа' ],
		[ 38, 'Потеря связи со стойкой' ],
		[ 39, 'Восстановление связи со стойкой' ],
		[ 40, 'Заканчивается бумага 1' ],
		[ 43, 'Дверь стойки закрыта' ],
		[ 44, 'Дверь стойки открыта' ],
		[ 45, 'Отказ шлагбаума' ],
		[ 47, 'Отказ принтера' ],
		[ 51, 'Переход в автоматический режим' ],
		[ 52, 'Переход в ручной режим' ],
		[ 53, 'Открытие шлагбаума' ],
		[ 54, 'Закрытие шлагбаума' ],
		[ 56, 'Разблокировка стойки' ],
		[ 63, 'Билет в лотке' ],
		[ 67, 'Продление аренды' ],
		[ 68, 'Удаление карты со стоянки' ],
		[ 69, 'Отказ в проезде: несоответствие зоны' ],
		[ 70, 'Добавление клиента' ],
		[ 71, 'Удаление клиента' ],
		[ 73, 'Потеря связи с сервером' ],
		[ 74, 'Восстановление связи с сервером' ],
		[ 75, 'Запуск сервера' ],
		[ 76, 'Остановка сервера' ],
		[ 77, 'Настройка сервера' ],
		[ 78, 'Въезд не зарегистрирован' ],
		[ 80, 'Изменение расписания для карты' ],
		[ 83, 'Удаление билета из базы' ],
		[ 84, 'Ошибка работы с ККМ' ],
		[ 85, 'Оплата билета невозможна, нет сдачи' ],
		[ 86, 'Оплаты не принимаются' ],
		[ 87, 'Оплаты принимаются' ],
		[ 88, 'Дверь автокассы открыта' ],
		[ 90, 'Восстановление питания' ],
		[ 91, 'Мало чековой ленты' ],
		[ 93, 'Инкассация (автокасса)' ],
		[ 94, 'Автоматическая инкассация (автокасса)' ],
		[ 96, 'Кассета устройства выдачи денег почти пуста' ],
		[ 100, 'Долг перед клиентом по последней операции' ],
		[ 101, 'Неисправность автокассы' ],
		[ 105, 'Станция Автоматическая касса' ],
	],
	'LogCardType'  => [
		[ 0, 'Билет', ],
		[ 8, 'Служебная карта', ],
		[ 11, 'Отсутствует', ],
		[ 12, 'Неизвестная карта', ],
		[ 13, 'VIP Служебная карта', ],
	],
];
foreach ($schema as $tablename => $data) {
	$db = new SQLite3('base.sqlite');
	$db->exec("pragma synchronous = off;");
	$db->exec("CREATE TABLE IF NOT EXISTS `{$tablename}` (`Id` INTEGER,`Name` TEXT)");
	$db->exec("DELETE FROM  {$tablename}");
	foreach ($data as $row) {
		$db->exec("INSERT INTO `{$tablename}` VALUES ({$row[0]},'{$row[1]}')");
	}
}


