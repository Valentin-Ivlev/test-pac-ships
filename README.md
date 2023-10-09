# Test-Pac-Ships

## Реализация проекта

Тек как в дампе базы данных приложенной к заданию, некоторые поля содержат HTML разметку, а иманно: заголовки, списки, параграфы с выравниванием текста, верхние индексы, ссылки,
в формы редактирования данных был интегрирован WYSIWYG редактор.

Для работы со списками (спецификация корабля и категории кают), была добавлена библиотека для реализации drag-and-drop, с ее помощью можно менять порядок элементов списков.

Также в интерфейсе есть возможность добавления новых элементов этих списков и удаления существующих.

#### Бибриотеки использованные в проекте:
Bootstrap &mdash; [https://getbootstrap.com/](https://getbootstrap.com/)<br>
Quill &mdash; [https://quilljs.com/](https://quilljs.com/)<br>
SortableJS/Sortable &mdash; [https://github.com/SortableJS/Sortable](https://github.com/SortableJS/Sortable)

#### Сборщик:
Vite &mdash; [https://vitejs.dev/](https://vitejs.dev/)

## Развертывание проекта

### Настройка на готовом web сервере:

Клонируйте проект:
```shell
git clone https://github.com/Valentin-Ivlev/test-pac-ships.git
```
Установите зависимости проекта:
```shell
composer install
npm install
```
Создайте свой файл настроек:
```shell
cp .env.example .env
```
Сгенерируйте ключ приложения:
```shell
php artisan key:generate
```
Настройете подключение к базе данных в файле `.env`

Установите правильные права на папки проекта: 
```shell
chmod 755 -R [путь к папке проекта]/
chmod -R o+w [путь к папке проекта]/storage
```
Настройте web-сервер, чтобы он указывал на папку `[путь к папке проекта]/public/`

Соберите frontend:
```shell
vite build
```
Очистите проект:
```shell
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```
Выполните миграции:
```shell
php artisan migrate
```
Заполните БД начальными данными:
```shell
php artisan db:seed
```
