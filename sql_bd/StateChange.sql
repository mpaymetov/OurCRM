SELECT * FROM ourcrm.state;

ALTER TABLE `ourcrm`.`state` 
CHANGE COLUMN `name` `name` VARCHAR(50) NOT NULL ;

INSERT INTO state
(id_state, name)
VALUES
(1, 'Установление контакта');

INSERT INTO state
(id_state, name)
VALUES
(2, 'Выявление потребностей');

INSERT INTO state
(id_state, name)
VALUES
(3, 'Выставление счета');

INSERT INTO state
(id_state, name)
VALUES
(4, 'Оплата');

INSERT INTO state
(id_state, name)
VALUES
(5, 'Поставка');

INSERT INTO state
(id_state, name)
VALUES
(6, 'Завершено');

INSERT INTO state
(id_state, name)
VALUES
(7, 'Отказ');

DELETE FROM state
WHERE id_state > 7;


UPDATE state
SET name='Установление контакта'
WHERE id_state=1;

UPDATE state
SET name='Выявление потребностей'
WHERE id_state=2;

UPDATE state
SET name='Выставление счета'
WHERE id_state=3;

UPDATE state
SET name='Оплата'
WHERE id_state=4;

UPDATE state
SET name='Поставка'
WHERE id_state=5;

UPDATE state
SET name='Завершено'
WHERE id_state=6;

UPDATE state
SET name='Отказ'
WHERE id_state=7;