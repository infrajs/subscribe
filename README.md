# Форма для номера телефона
Указанный посетителем Email отправляется по почте и сохраняется в файле.
Используется также для заказа обратного звонка.

## Установка через composer
```json
{
  "require":{
    "infrajs/subscribe":"~1"
  }
}
```

## Использование

Подкючить слой и указать в нём нужные параметры
```
{
	"external":"-subscribe/subscribe.layer.json",
	"config":{
		"placeholder":"Email",
		"submit":"Подписаться",
		"btnclass":"btn-success",
	}
}
```


