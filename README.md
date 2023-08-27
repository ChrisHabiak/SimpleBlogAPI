# SimpleBlogAPI

## Opis

SimpleBlogAPI to projekt API do prostego bloga, który zawiera funkcjonalności związane z rejestracją, logowaniem, zarządzaniem użytkownikami i postami.


## Wymagania

- PHP >= 8.1
- Composer
- Baza danych MySQL 8++
- Serwer Apache lub Nginx
- Redis

## Instalacja

1. Sklonuj repozytorium projektu.
2. Uruchom `composer install`, aby zainstalować wszystkie zależności.
3. Skopiuj plik `.env.example` do `.env` i skonfiguruj dostęp do bazy danych.
4. Uruchom `php artisan migrate`, aby utworzyć tabele w bazie danych.
5. Opcjonalnie, uruchom `php artisan db:seed`, aby wygenerować dane testowe przy użyciu Fakera.
6. Opcjonalnie, uruchom `php artisan test`, aby przeprowadzić testy jednostkowe.

## Użytkownie

Możesz skorzystać z komendy Artisan, która umożliwi szybkie utworzenie konta użytkownika. W terminalu, w głównym katalogu projektu, wpisz:

```bash
php artisan create:user
```

Podążaj za instrukcjami w konsoli, aby podać potrzebne informacje, takie jak e-mail, hasło i rolę użytkownika.

## API - endpointy

**Zarządzanie Postami**

- `GET /posts`: Pobierz listę wszystkich postów z paginacją.
- `GET /posts/{id}`: Pobierz szczegóły konkretnego posta o podanym ID.
- `POST /posts`: Dodaj nowy post. Wymaga uwierzytelnienia. Pola: title, content, photo (plik graficzny opcjonalnie, maks 4MB).
- `PUT /posts/{id}`: Zaktualizuj istniejący post o podanym ID. Wymaga uwierzytelnienia. Pola: title, content.
- `DELETE /posts/{id}`: Usuń post o podanym ID. Wymaga uwierzytelnienia.

**Autentykacja**

- `POST /auth/register`: Zarejestruj nowego użytkownika. Pola: name, email, password.
- `POST /auth/login`: Zaloguj użytkownika. Pola: email, password.
- `POST /auth/send-reset-password-link`: Wyślij link do resetowania hasła. Pola: email.
- `POST /auth/reset-password`: Zresetuj hasło na podstawie otrzymanego linka resetującego. Pola: email, password, token.
- `POST /auth/logout`: Wyloguj zalogowanego użytkownika. Wymaga uwierzytelnienia.

**Zarządzanie Użytkownikami**

Dostępne tylko dla użytkowników o roli "Administrator".

- `GET /users`: Pobierz listę użytkowników.
- `GET /users/{id}`: Pobierz szczegóły użytkownika o podanym ID.
- `POST /users`: Dodaj nowego użytkownika. Pola: name, email, password, role_id (puste, null - zwykły użytkownik, 1 - administrator, 2 - edytor).
- `PUT /users/{id}`: Zaktualizuj istniejącego użytkownika o podanym ID. Pola: name, email, password, role_id (puste, null - zwykły użytkownik, 1 - administrator, 2 - edytor).
- `DELETE /users/{id}`: Usuń użytkownika o podanym ID.

### Uwagi
- Wszystkie zasoby dostępne w tym API są chronione przez middleware uwierzytelniające (Sanctum).
- Endpoints, które wymagają uwierzytelnienia, są dostępne tylko dla użytkowników zalogowanych.


## Odpowiedzi na pytania ze specyfikacji zadania rekrutacyjnego

### Etapy powstawania projektu (od czego zaczęto pracę, jak została ona podzielona?)
1) **Analiza wymogów i natury projektu**
- Ocena wymogów projektowych zgodnych ze specyfikacją, zwłaszcza implementacją wzorców projektowych.

2) **Koncepcyjne modelowanie danych i procesów**
- Tworzenie konceptualnego modelu danych i procesów systemowych, uwzględniającego charakterystykę danego projektu oraz postawione wymagania.

3) **Kodowanie**
- Wdrażanie zdefiniowanych funkcjonalności w oparciu o wcześniejszy model i wykorzystanie wskazanych technologii.

4) **Testy ręczne i automatyczne oraz korekty**
- Przeprowadzenie zarówno ręcznych, jak i automatycznych badań w celu potwierdzenia właściwości i jakości kodu.
- Wprowadzenie poprawek i usunięcie wykrytych niedoskonałości podczas procesu testowania.

### Z jakimi częściami miałeś /miałaś problem i dlaczego?

Nie miałem żadnych problemów.

### Które części uważasz że można by lepiej dopracować gdybyś miał/a więcej czasu?

Lepsze cachowanie i optymalizacja, zabezpieczenia API przed atakami typu brute force i innymi zagrożeniami związanymi z bezpieczeństwem, większe pokrycie kodu testami,
niektóre części kodu i większość komentarzy tworzyłem szybko za pomocą AI dlatego wymagają one refaktoryzacji.


