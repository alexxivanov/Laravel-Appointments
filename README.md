# Laravel Appointments — запазване на часове

WEB и API приложение за управление на часове, изградено с **Laravel 12**, включващо:
- CRUD операции за часовете (добавяне, преглед, редакция, изтриване)
- Филтриране, странициране и детайлен преглед
- Избор на метод за нотификация (SMS / Email)
- API endpoints за всички функционалности
- Кеширане на списъците (демо на Cache механизма)
- Валидация с custom правило за ЕГН
- Bootstrap 5 интерфейс

---

## Инсталация и стартиране

```bash
git clone https://github.com/alexxivanov/Laravel-Appointments.git
cd appointments
composer install
cp .env.example .env
php artisan key:generate
```

### Конфигурация на DB в `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appointments
DB_USERNAME=root
DB_PASSWORD=
```

### Миграции и тестови данни
```bash
php artisan migrate --seed
```
Забележка: ЕГН-тата при seed не са реални


```bash
php artisan serve
```
[http://localhost:8000](http://localhost:8000)

---

## Основен интерфейс и функционалности

| Страница | Описание |
|-----------|-----------|
| `/appointments` | Списък на всички часове (филтриране, странициране) |
| `/appointments/create` | Форма за добавяне на нов час |
| `/appointments/{id}` | Детайлен преглед + предстоящи часове за същия клиент |
| `/appointments/{id}/edit` | Редактиране на час |
| — | Изтриване с потвърждение |

При успешно създаване или редакция се показва ** bootstrap toast pop-up** със съобщение напр.:
> „Успешно запазихте час! Клиентът ще бъде уведомен чрез [SMS/Email].“

---

## API

| Метод | Endpoint | Описание |
|--------|-----------|-----------|
| `GET` | `/api/v1/appointments` | Списък с филтри и странициране |
| `POST` | `/api/v1/appointments` | Създаване на нов час |
| `GET` | `/api/v1/appointments/{id}` | Детайлен преглед |
| `PUT` | `/api/v1/appointments/{id}` | Редактиране |
| `DELETE` | `/api/v1/appointments/{id}` | Изтриване |


---

## Валидация

- `scheduled_at` — валидна дата/час в бъдещето
- `client_name` — минимум 2 символа
- `egn` — 10 цифри, с проверка на дата и контролна цифра (с custom Rule - `App\Rules\ValidEgn`)
- `notification_method` — само sms или email

---

## Нотификации (Strategy Pattern)

Нотификациите са реализирани чрез **стратегии** в `App\Services\Notifications`:
- `SmsChannel` - връща текст „Клиентът ще бъде уведомен чрез SMS.“
- `EmailChannel` - връща текст „Клиентът ще бъде уведомен чрез Email.“
- Лесно добавяне на нов тип (напр.`PushChannel`)

---

## Кеширане

Списъкът с часове (`index` на Web/API) използва **Laravel Cache** (`Cache::remember`):
- кеш ключ на база филтри и страница;
- TTL 30 секунди;
- кешът се изчиства при добавяне, редакция или изтриване.

По подразбиране се използва `file` драйвер (`storage/framework/cache/data`).

---

## Потенциални подобрения
- Redis кеш за production 
- Уведомления чрез реални канали (`Mail::`, `SMS Gateway`)
- API Authentication 
- Queue за асинхронни задачи (изпращане на мейли, смс и т.н.)

---
