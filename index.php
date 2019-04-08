<?php 
session_start();      

include ("pages/bd.php");

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
  {
    //если существует логин и пароль в сессиях, то проверяем их и    извлекаем аватар
    $password = $_SESSION['password'];
    $login    = $_SESSION['login'];
    $result = mysql_query("SELECT id,avatar FROM users WHERE login='$login' AND password='$password'",$db); 
    $myrow  = mysql_fetch_array($result);
  }

  header('Content-Type: text/html; charset=utf-8');
 
  $db_host = 'localhost';
  $db_username = 'mysql';
  $db_password = 'mysql';
  $db_name = 'messages';
  $db_charset = 'utf8';
 
  $is_connected = @mysql_connect($db_host, $db_username, $db_password);
  $is_db_selected = $is_connected ? @mysql_select_db($db_name) : FALSE; 
 
  $errors = array();
 
  if (!$is_connected) $errors[] = 'Не могу соединиться с базой данных';
  if (!$is_db_selected) $errors[] = 'Не могу найти базу данных';
 
  if (!empty($_POST['f_submit']) AND $is_connected AND $is_db_selected)
  {
    if (empty($_POST['f_text']) OR !trim($_POST['f_text']))
    {
      $errors[] = 'Не введен текст сообщения!';   
    }
    else
    {
      if (mb_strlen(trim($_POST['f_text']), 'utf-8')>255)
      {
        $errors[] = 'Текст сообщения не может превышать 255 символов!';
      }
      else
      {
        $sql = 'INSERT INTO `messages` SET
              `message`="'.mysql_real_escape_string(trim($_POST['f_text'])).'",
              `date`=NOW()';
 
        $result = mysql_query($sql) 
            or die('Query error: <code>'.$sql.'</code>');
 
        Header('Location:?');
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="">

  <head>
    <title>HW-Service</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
  </head>

<body id="top">
  <div class="bgded overlay" style="background-image:url('images/demo/backgrounds/wer.jpg');"> 
    <div class="wrapper row1">
      <header id="header" class="hoc clear"> 

        <div id="logo" class="fl_left">
         <h1><a href="index.php">HW-Service</a></h1>
        </div>

        <nav id="mainav" class="fl_right">
          <ul class="clear">
            <li class="active"><a href="index.php">Домашняя страница</a></li>
            <li><a href="pages/gallery.php">Галлерея</a></li>
            
       
         <?php
          if (!isset($myrow['avatar']) or $myrow['avatar']=='') 
            {
              print <<< HERE
              <a class="font=xs brd" href='pages/authorization.php'>авторизация</a>
              <a class="font=xs brd" href='pages/registration.php'>регистрация</a>
HERE;
            }
else
    {
      print <<< HERE
      | Пользователь $_SESSION[login]
       <a href="pages/lk.php?id=$_SESSION[id]">Личный кабинет</a>  |  <a class="font=xs" href='pages/exit.php'>выход</a> |
HERE;
    }
          ?>
        </ul>
      </nav>
    </header>
  </div>

  <div class="wrapper">
    <p text align="center" class="font-x2"  > HW-Service — надежный сервис вашего компьютеров! </p>
  </div>

  <div class="wrapper">
      <article id="slideintro" class="hoc clear"> 
         <div class="slider overlay">
              <img src="images/slider1.jpg">
              <img src="images/slider2.jpg">
              <img src="images/slider3.jpg">
              <img src="images/slider4.jpg"> 
            </div> 
      <?php
     

        if (!isset($myrow['avatar']) or $myrow['avatar']=='')  
        {
          print <<< HERE
          <div class="overlay row1" >
<label text align="center"> Добро пожаловать <a class="font-x1" href="pages/lk.php?id=$_SESSION[id]"> $_SESSION[login]</a></label>

          <label text align="center"> 
            <a class="font=x1" href='pages/authorization.php'>Авторизуйтесь</a>
            или
            <a class="font=x1" href='pages/registration.php'>зарегистрируйтесь</a>
            
          </label>
              </div>
HERE;
  } 
      else {
   print <<< HERE
        <label text align="center"> Добро пожаловать <a class="font-x1" href="pages/lk.php?id=$_SESSION[id]"> $_SESSION[login]</a></label>
          
HERE;
      }          
        ?>
      <br>
    </div>

      </article>
  </div>
</div>
<!-- Блок цитаты -->
<div class="wrapper row3">
  <main class="hoc container clear">  
    <article class="group">

      <div class="one_quarter first ">
        <p class="font-x2" text align ="center">Более 5 лет на рынке услуг!</p>
        <img src="images/demo/backgrounds/logo.jpg" class="img" alt="" />
      </div>

      <div class="three_quarter">
        <p class="font-x2"> В нашем компьютерном сервисном центре предоставляются: </p>
        <p class="btmspace-30">
<p> ▬ Бесплатная диагностика</p>
<p> ▬ Бесплатный выезд мастера к клиенту</p>
<p> ▬ Бесплатная доставка на ремонт в СЦ и обратно</p>
<p> ▬ Бесплатные консультации по ремонту компьютеров</p>
<p> ▬ Бесплатная доставка комплектующих</p>
<p> ▬ Круглосуточный прием заявок</p>
<p> ▬ Оригинальные комплектующие</p>
<p> ▬ Комплектующие всегда в наличии</p>
<p> ▬ Скидки на ремонт до 25 %</p>
<p> ▬ Цены: от 350 руб</p>
</p>
      <p > Мы быстро производим ремонт и даём 100% гарантию на ВСЕ выполненные работы</p>
      </div>
    </article>
  </main>
</div>
<!-- Рекламный блок -->
<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/sky.jpg');">
  <section class="hoc container clear"> 
     <div class="sectiontitle">
      <h6 class="heading">Hardware Service - это ваш помощник в трудных ситуациях</h6>
      <p>Мы предоставляем лучшие услуги на рынке</p>
    </div>
    <ul class="nospace group elements">
      <li class="one_third first">
        <article><i class="fa fa-chain-broken"></i>
          <h6 class="heading">Гарантия до 3-х лет</h6>
          <p>Мы заменим комплектующие в случае выхода из строя за свой счет</p>
        </article>
      </li>
      <li class="one_third">
        <article><i class="fa fa-ambulance"></i>
          <h6 class="heading">Бесплатная доставка</h6>
          <p>Развитая логистическая сеть! Доставим товары в любую точку РФ </p>
        </article>
      </li>
      <li class="one_third">
        <article><i class="fa fa-area-chart"></i>
          <h6 class="heading">Обновление комплектующих</h6>
          <p>По вашему желанию наш специалист лично заменит выбранные вами комплектующие</p>
        </article>
      </li>
      <li class="one_third first">
        <article><i class="fa fa-clock-o"></i>
          <h6 class="heading">Обслуживание и поддержка</h6>
          <p>Осуществляем сопровождение на всех этапах предоставления услуг</p>
          </article>
      </li>
      <li class="one_third">
        <article><i class="fa fa-gamepad"></i>
          <h6 class="heading">Время геймеров</h6>
          <p>Мы как никто другой понимаем страсть к играм и делаем все для комфортного гейминга</p>
        </article>
      </li>
      <li class="one_third">
        <article><i class="fa fa-thumbs-up"></i>
          <h6 class="heading">Высокое качество услуг</h6>
          <p>Огромный опыт работы и знания наших сотрудников позволяют оказывать услуги на высоком уровне</p>
        </article>
      </li>
    </ul>
  </section>
</div>
  <!-- Блок команды разработчиков-->
<div class="wrapper row3"  >
  <section class="hoc container clear"> 
    <div class="sectiontitle">
      <h6 class="heading">Наша команда</h6>
      <p>Вместе мы можем многое!</p>
    </div>
    <div class="group">
      <figure class="one_third first"><a href="#"><img class="btmspace-30" src="images/demo/av2.jpg" alt=""></a>
        <figcaption>
          <h6 class="heading font-x1">С. Карпов</h6>
          <em class="font-xs">Специалист по работе с клиентами</em>
         
            <ul class="faico ">
                <li><a class="faicon-vk" href="https://vk.com/karpov.stanislav"><i class="fa fa-vk"></i></a></li>
            </ul>
       
        </figcaption>
      </figure>
      <figure class="one_third"><a href="https://vk.com/id321300253"><img class="btmspace-30" src="images/demo/av1.jpg" alt=""></a>
        <figcaption>
          <h6 class="heading font-x1">А. Джамалдаев</h6>
          <em class="font-xs">Специалист по программному обеспечению</em>
          <footer>
            <ul class="faico clear">
         
              <li><a class="faicon-vk" href="https://vk.com/id321300253"><i class="fa fa-vk"></i></a></li>
            </ul>
          </footer>
        </figcaption>
      </figure>
      <figure class="one_third"><a href="https://vk.com/id133167212"><img class="btmspace-30" src="images/demo/av3.jpg" alt=""></a>
        <figcaption>
          <h6 class="heading font-x1">М. Рогоза</h6>
          <em class="font-xs">Специалист по техническому обеспечению</em>
          <footer>
            <ul class="faico clear">
              
              <li><a class="faicon-vk" href="https://vk.com/id133167212"><i class="fa fa-vk"></i></a></li>
            </ul>
          </footer>
        </figcaption>
      </figure>
  
    </div>
   </section>
</div>
<!-- Блок ссылок. -->
<div class="wrapper row4">

  <footer id="footer" class="hoc clear">

    <div class="one_half">
      <h6 class="font-x1"><a href="#">Как с нами связаться</a></h6>
      <ul class="nospace btmspace-50 linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>Пер. Некрасовский, 44 &amp; Ул. Энгельса, 1</address>
        </li>
        <li><i class="fa fa-phone"></i> 8 800 555 35 35</li>
        <li><i class="fa fa-envelope-o"></i> info@sfedu.ru</li>
      </ul>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>
      </ul>
    </div>

    <div class="one_quarter">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5421.135082203947!2d38.93530273388119!3d47.20547641465503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40e3fd186d3d27a1%3A0xcdb553d152cb3d0!2z0JjQvdC20LXQvdC10YDQvdC-LdGC0LXRhdC90L7Qu9C-0LPQuNGH0LXRgdC60LDRjyDQsNC60LDQtNC10LzQuNGPINCu0LbQvdC-0LPQviDRhNC10LTQtdGA0LDQu9GM0L3QvtCz0L4g0YPQvdC40LLQtdGA0YHQuNGC0LXRgtCw!5e0!3m2!1sru!2sru!4v1552676884509" width="400" height="320" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
  </footer>
</div>
 <!--Самый нижний элемент -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <p class="fl_right">Таганрог 2019</p>
    <p class="fl_left">Разработано студентами группы КТбо4-9 <a target="_blank" href="https://vk.com/karpov.stanislav" title="Страница ВКонтакте">Карпов С.М.</a></p>
  </div>
</div>
 <!-- Кнопка поднятия наверх -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>