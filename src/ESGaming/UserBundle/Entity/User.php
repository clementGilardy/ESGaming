<?php

namespace ESGaming\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\True;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESGaming\UserBundle\Entity\UserRepository")
 */

class User implements UserInterface
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
     *
     * @ORM\Column(name="first_name", type="string", length=50)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=50, unique=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="lol_nickname", type="string", length=50, unique=true, nullable=true)
     */
    private $lol_nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_nickname", type="string", length=50, unique=true, nullable=true)
     */
    private $steam_nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="origin_nickname", type="string", length=50, unique=true, nullable=true)
     */
    private $origin_nickname;

    /**
     * @var date
     *
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=100)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\ManyToOne (targetEntity="ESGaming\UserBundle\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $secretQuestion;

    /**
     * @Assert\File(maxSize="1M")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var integer
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_answer", type="string", length=50)
     */
    private $secretAnswer;

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean", options={"default":true})
     */
    private $activate;

    /**
     * Get id
     *
     * @return integer
     */

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt = "esg@ming-s@lt";


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set secretQuestion
     *
     * @param integer $secretQuestion
     *
     * @return User
     */
    public function setSecretQuestion($secretQuestion)
    {
        $this->secretQuestion = $secretQuestion;

        return $this;
    }

    /**
     * Get secretQuestion
     *
     * @return integer
     */
    public function getSecretQuestion()
    {
        return $this->secretQuestion;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/profile_pictures';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->picture = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        $this->picture = $this->getUploadDir().'/'.$this->file->getClientOriginalName();

        $this->file = null;
    }

    /**
     * Set role
     *
     * @param integer $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set secretAnswer
     *
     * @param string $secretAnswer
     *
     * @return User
     */
    public function setSecretAnswer($secretAnswer)
    {
        $this->secretAnswer = $secretAnswer;

        return $this;
    }

    /**
     * Get secretAnswer
     *
     * @return string
     */
    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }


    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return User
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /*public function __construct()
    {
        $this->activate = true;
        $this->salt = plaintext(uniqid(null, true));
    }*/

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');

    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set lolNickname
     *
     * @param string $lolNickname
     *
     * @return User
     */
    public function setLolNickname($lolNickname)
    {
        $this->lol_nickname = $lolNickname;

        return $this;
    }

    /**
     * Get lolNickname
     *
     * @return string
     */
    public function getLolNickname()
    {
        return $this->lol_nickname;
    }

    /**
     * Set steamNickname
     *
     * @param string $steamNickname
     *
     * @return User
     */
    public function setSteamNickname($steamNickname)
    {
        $this->steam_nickname = $steamNickname;

        return $this;
    }

    /**
     * Get steamNickname
     *
     * @return string
     */
    public function getSteamNickname()
    {
        return $this->steam_nickname;
    }

    /**
     * Set originNickname
     *
     * @param string $originNickname
     *
     * @return User
     */
    public function setOriginNickname($originNickname)
    {
        $this->origin_nickname = $originNickname;

        return $this;
    }

    /**
     * Get originNickname
     *
     * @return string
     */
    public function getOriginNickname()
    {
        return $this->origin_nickname;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
}
