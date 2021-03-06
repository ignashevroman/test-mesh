## Запуск
Запускается как дефолтный laravel 8 проект через laravel sail

## Краткая инфа по проекту
Ключевой момент - импорт записей из Excel. В процессе реализации столкнулся с тремя проблемами:

1. При наличии формул в таблице, реализация интерфейса `WithChunkReading` приводит к неправильному их расчету. 
В данном случае при чтении следующего чанка `id` сбрасывается к 1.

2. Невозможно корректно использовать расчет формул `WithCalculatedFormulas` и `SkipsEmptyRows` так как формулы перестают считаться. 
Данную проблему описал в репозитории пакета `maatwebsite/excel` (https://github.com/Maatwebsite/Laravel-Excel/issues/3127).
В качестве простого и быстрого решения сделал свой счетик строчек в файле, так как `RemembersRowNumber` без `SkipsEmptyRows` считает и пустые строчки,
а условием пропуска строки является пустая ячейка в колонке `id`.

3. Чтобы корректно сохранять прогресс импорта в redis нужно было сохранять его только после записи сущностей в базу данных, а не раньше.
Пакет не предоставляет возможности отловить подобное событие, поэтому я решил создать создать свой прокси-класс для `ModelManager`,
который дополняет функционал метода `flush`, при необходимости запуская специальное событие, на которое мы можем отреагировать.
С помощью контейнера зависимостей подменил реализацию `ModelManager` на `ModelManagerProxy`.