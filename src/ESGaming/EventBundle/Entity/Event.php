<?php

namespace ESGaming\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESGaming\EventBundle\Entity\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="ESGaming\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var string
     * @ORM\OneToOne(targetEntity="ESGaming\GameBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;


    /**
     *@var string
     *
     * @ORM\Column(name="event", type="string", length=255)
     */
    private $event;


    /**
     *
     */

    /**
     * Get id
     *
     * @return integer
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Event
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return Event
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return Event
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return News
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}

