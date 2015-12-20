<?php

namespace ESGaming\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ESGamingEventBundle:Default:index.html.twig', array('name' => $name));
    }


    public function addAction()
    {
        $dbh = new PDO('mysql:host=localhost;dbname=esgaming', 'root', ''); ?>

        <form>

            <label>Titre : </label><input type="text" name="title"/>
            <label>Description : </label> <textarea name="text" placeholder="Entrez votre message" . rows="8"
                                                    cols="45"></textarea>

            <input type="submit" value="Valider"
                   name="non"/>

        </form>

        <?php $request = "INSERT INTO event (title, event) VALUES (:title,:event)";

        $rep = $dbh->prepare($request);

        $exec = $rep->execute(array('title' => $_POST['title'], 'event' => $_POST['event']));

    }


    public function newAction()
    {

        $dbh = new PDO('mysql:host=localhost;dbname=esgaming', 'root', '');

        $request = 'SELECT title, id FROM event';

        $event = $dbh->query($request);

        if(is_object($event)){

        $news = $event->fetchAll(PDO::FETCH_ASSOC);
    }
        foreach($news as $value){

        echo ("Titre:".$value['title'].'<br>'."id:".$value['id'].'<br>');

        $id = $value['id'];

    }

    $dbh = new PDO('mysql:host=localhost;dbname=esgaming', 'root', '');

    $request = 'DELETE FROM event WHERE id='.$_GET['id'];

    $rep = $dbh->prepare($request);

        $event = $dbh->query($request);

    }


}
?>
