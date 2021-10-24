Symfony Skeleton
====================

### Структура Каталогов

```
src/
    SomeModule/
        Api/                Интерфейс для внешнего взаимодействия
        Application/        Службы приложения, команды, хэндлеры и т.п.
        Domain/             Доменная модель
        Infrastructure/     Хранение данных, метрики и т.п.
            Adapter/        Предохранительный слой: адаптеры к интерфейсам других модулей
        UI/                 Веб-контроллеры, REST, консольные команды и т.п.
    Shared/
        Application/
        Domain/
        Infrastructure/
        UI/
```

Приложение разделено на модули(ограниченные контексты, Bounded Contexts) + общая часть Shared.
У каждого модуля есть интерфейс (каталог Api) через который осуществляется доступ к его функционалу. Этот интерфейс принимает и возвращает данные только с помощью специальных DTO, хранящихся в этом же каталоге.
Для взаимодействия с интерфейсом другого модуля необходимо реализовать специальный адаптер (предохранительный слой, Anti-corruption Layer) в каталоге Infrastructure/Adapter, который будет обращаться к Api и конвертировать полученные от стороннего модуля DTO в свои. 

Внутри каждого модуля также есть разделение на слои: UI, Application, Domain, Infrastructure

### INSTALLATION

Скопировать файл _.env.example_ в _.env_ и заполнить реальными учетными данными при необходимости.

Запуск docker-контейнеров
```
make up
```

Создание БД, применение миграций и заполнение справочников
```
make init
```

### USAGE

#### Миграции
Общие миграции хранятся в _src/Shared/Infrastructure/Persistence/Doctrine/Migration_.

Для модулей в _src/-ModuleName-/Infrastructure/Persistence/Doctrine/Migration_. При добавлении нового модуля необходимо прописать путь к каталогу с миграциями в _config/packages/doctrine_migrations.php_

В postgres можно разделять таблицы из разных модулей с помощью схем.

#### Doctrine
Маппинги и кастомные типы хранятся в _src/-ModuleName-/Infrastructure/Persistence/Doctrine_
Их необходимо регистрировать в _config/packages/doctrine/-module-name-/mappings.php_ и _config/packages/doctrine/-module-name-/types.php_ соответственно.

#### Message Bus
В качестве шины сообщений используется [Symfony Messenger](https://symfony.com/doc/current/components/messenger.html).

Посмотреть список сообщений и их обработчики можно с помощью команды
```                                                                         
php bin/console debug:messenger                                             
```                                                                         

По умолчанию шина работает в синхронном режиме.

##### Events

Для событий используется шина **event.bus**, у каждого сообщения может быть 0 и более обработчиков.
Чтобы отправить в нее сообщение необходимо внедрить с помощью контейнера зависимостей **MessageBusInterface $eventBus**

```php  
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function test(): void        
    {                                                                 
        $this->eventBus->dispatch(new Event());                                  
    }                                                                 
```

Обработчики событий хранятся в каталогах _src/-ModuleName-/Application_.
Они должны реализовывать интерфейс _src/Shared/Infrastructure/MessageBus/EventHandlerInterface_,

По умолчанию

##### Commands

Для команд используется шина **command.bus**, у каждого сообщения должен быть ровно один обработчик.
Чтобы отправить в нее сообщение необходимо внедрить с помощью контейнера зависимостей **MessageBusInterface $commandBus**

```php                                                                                                                                  
    private MessageBusInterface $commandBus;                                                                                              
                                                                                                                                        
    public function __construct(MessageBusInterface $commandBus)                                                                          
    {                                                                                                                                   
        $this->commandBus = $commandBus;                                                                                                    
    }                                                                                                                                   
                                                                                                                                        
    public function test(): void                                                                                                        
    {                                                                                                                                   
        $this->commandBus->dispatch(new Command());                                                                                         
    }                                                                                                                                   
```                                                                                                                                     

Обработчики команд хранятся в каталогах _src/-ModuleName-/Application_.
Они должны реализовывать интерфейс _src/Shared/Infrastructure/MessageBus/CommandHandlerInterface_


#### Консольные команды

Запуск всех инитеров
```
php bin/console app:init:all
```

#### METRICS

Метрики доступны по адресу _/metrics/prometheus_

Для добавления новой метрики достаточно реализовать интерфейс **App\Shared\Infrastructure\Metric\MetricInterface**

#### Проверки

Доступны две проверки:

_/check/health_ - всегда отвечает **200**

_/check/readiness_ - отвечает **200**, если есть соединение до базы, иначе - **500**

### TESTS

Тесты запускаются в специальном контейнере **sut**

Запуск тестов:
```
make tests
```

Проверка code style, стат анализ + deptrac 
```
make check
```