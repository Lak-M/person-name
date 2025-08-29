# Person Name

<img src="https://github.com/user-attachments/assets/ef6088e7-4de5-45c2-b804-0c46b27c918e" width="840" alt="Image"/>

## This package globally handle person names in various formats.

## Insight

### Problem

- A company decided to automating their business by developing a website. Database has user's table with normalized name field (`first_name`, `middle_name`, `last_name`).
  but legacy Excel sheets have user's full name column. It wasn't a problem for legacy system as things are handled manually and human are good with full names.
  But now, the company wants to import legacy data to new system. They need to split full name into first, middle and last names.
  If it feels like an easy task, just take a minutes and think about it seriously. One solution you can hire a person to do this task manually but
  the accuracy can be guaranteed. You can automate this task using AI or write some logic again it gonna cost you some money and can't guarantee the accuracy.
  You will agree with me none of those methods are smooth and reliable. You will have to spend time and efforts to it specially when the client list 
  contains names from **different countries**. This is when this package comes in handy. with this package all you need to do following,
```php
$n = PersonName::fromFullName($fullName, $country);

$firstName = $n->first();
$middleName = $n->middle();
$lastName = $n->last();
```
  
- Your database has user's table with `full_name` field. This is a bad DB design but it exists. Now you need to extract parts.

- Front-end needs names in different format. UI need short name, form need names in standard format, security related things need redated name.
  like-wise abbreviated, sorted etc. With this package covers all the cases as much as possible.

## Motive
 I've faced the problems described [above](#problem) and alwatys needed a solid solution which I coundn't find still. Recetly I show this package
and I thought this what I waiting for so long. But when I dig into it I realize it cannot fullfill my expectations. It can do simple things but not complex 
scenarios. So I decided to stop waiting and develop a solution by myself. I must give credits to this package as it ignited the spark.

