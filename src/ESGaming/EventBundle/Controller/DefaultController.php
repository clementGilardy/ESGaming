<?php

namespace ESGaming\EventBundle\Controller;

use ESGaming\EventBundleBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            <label>Description : </label> <textarea name="text" placeholder="Entrez votre événement" . rows="8"
                                                    cols="45"></textarea>

            <input type="submit" value="Valider"
                   name="non"/>

        </form>

        <?php $request = "INSERT INTO event (title, event) VALUES (:title,:event)";

        $rep = $dbh->prepare($request);

        $exec = $rep->execute(array('title' => $_POST['title'], 'event' => $_POST['event']));

    }


    public function deleteAction()
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

    public function affichageTousAction()
    {
    $dbh = new PDO('mysql:host=localhost;dbname=esgaming', 'root', '');
    $request = 'SELECT title, event FROM event';
    $message = $dbh->query($request);

        $news = $message->fetchAll(PDO::FETCH_ASSOC);


    foreach($news as $value){

        echo "Titre:    ".$value['title'].'<br>';
        echo "Evenement:    ".$value['event'].'<br>';

    }
    ?>



    }


}
?>
