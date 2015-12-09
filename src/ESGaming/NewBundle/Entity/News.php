<?php

namespace ESGaming\NewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ESGaming\NewBundle\Entity\NewsRepository")
 */
class News
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
     * @ORM\ManyToOne(targetEntity="ESGaming\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @Assert\File(maxSize="1M")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="main_banner", type="text", nullable=true)
     */
    private $mainBanner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ESGaming\NewBundle\Entity\Status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\ManyToOne(targetEntity="ESGaming\NewBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="ESGaming\CommentBundle\Entity\Comment", mappedBy="id")
     */
    private $comments;

    public function __construct()
    {
        $this->postDate = new \DateTime();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return News
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($f)
    {
        $this->file = $f;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/main_banner';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->mainBanner = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
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

        $this->mainBanner = $this->getUploadDir().'/'.$this->file->getClientOriginalName();

        $this->file = null;
    }


    /**
     * Set mainBanner
     *
     * @param string $mainBanner
     *
     * @return News
     */
    public function setMainBanner($mainBanner)
    {
        $this->mainBanner = $mainBanner;

        return $this;
    }

    /**
     * Get mainBanner
     *
     * @return string
     */
    public function getMainBanner()
    {
        return $this->mainBanner;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return News
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set author
     *
     * @param \ESGaming\UserBundle\Entity\User $author
     *
     * @return News
     */
    public function setAuthor(\ESGaming\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \ESGaming\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set status
     *
     * @param \ESGaming\NewBundle\Entity\Status $status
     *
     * @return News
     */
    public function setStatus(\ESGaming\NewBundle\Entity\Status $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \ESGaming\NewBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param \ESGaming\NewBundle\Entity\Type $type
     *
     * @return News
     */
    public function setType(\ESGaming\NewBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \ESGaming\NewBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
}
