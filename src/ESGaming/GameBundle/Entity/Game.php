<?php

namespace ESGaming\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Game
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_short", type="string", length=255)
     */
    private $descShort;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_long", type="text")
     */
    private $descLong;

    /**
     * @var string
     *
     * @ORM\Column(name="editor", type="string", length=50)
     */
    private $editor;

    /**
     * @var string
     *
     * @ORM\Column(name="developer", type="string", length=50)
     */
    private $developer;

    /**
     * @ORM\ManyToMany(targetEntity="ESGaming\EventBundle\Entity\Event", inversedBy="games")
     * @ORM\JoinColumn(nullable=true)
     */
    private $events;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="date")
     */
    private $releaseDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="mark", type="integer")
     */
    private $mark;

    /**
     * @var array
     *
     * @ORM\Column(name="support", type="array")
     */
    private $support;

    /**
     * @var string
     *
     * @ORM\Column(name="download_link", type="string", length=255)
     */
    private $downloadLink;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @Assert\File(maxSize="1M")
     */
    private $logoFile;

    /**
     * @var array
     *
     * @ORM\Column(name="classification", type="array")
     */
    private $classification;

    /**
     * @var string
     *
     * @ORM\Column(name="banner", type="string", length=255)
     */
    private $banner;

    /**
     * @Assert\File(maxSize="1M")
     */
    private $bannerFile;

    /**
     * @var string
     *
     * @ORM\Column(name="trailer", type="string", length=255)
     */
    private $trailer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;


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
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set descShort
     *
     * @param string $descShort
     *
     * @return Game
     */
    public function setDescShort($descShort)
    {
        $this->descShort = $descShort;

        return $this;
    }

    /**
     * Get descShort
     *
     * @return string
     */
    public function getDescShort()
    {
        return $this->descShort;
    }

    /**
     * Set descLong
     *
     * @param string $descLong
     *
     * @return Game
     */
    public function setDescLong($descLong)
    {
        $this->descLong = $descLong;

        return $this;
    }

    /**
     * Get descLong
     *
     * @return string
     */
    public function getDescLong()
    {
        return $this->descLong;
    }

    /**
     * Set editor
     *
     * @param string $editor
     *
     * @return Game
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return string
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set developer
     *
     * @param string $developer
     *
     * @return Game
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * Get developer
     *
     * @return string
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Game
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Game
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set mark
     *
     * @param integer $mark
     *
     * @return Game
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set support
     *
     * @param array $support
     *
     * @return Game
     */
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return array
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set downloadLink
     *
     * @param string $downloadLink
     *
     * @return Game
     */
    public function setDownloadLink($downloadLink)
    {
        $this->downloadLink = $downloadLink;

        return $this;
    }

    /**
     * Get downloadLink
     *
     * @return string
     */
    public function getDownloadLink()
    {
        return $this->downloadLink;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Game
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function setLogoFile($f)
    {
        $this->logoFile = $f;
    }

    public function getBannerFile()
    {
        return $this->bannerFile;
    }

    public function setBannerFile($f)
    {
        $this->bannerFile = $f;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/game_images';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->bannerFile) {
            // faites ce que vous voulez pour générer un nom unique
            $this->banner = sha1(uniqid(mt_rand(), true)).'.'.$this->bannerFile->guessExtension();
        }

        if (null !== $this->logoFile) {
            // faites ce que vous voulez pour générer un nom unique
            $this->logo = sha1(uniqid(mt_rand(), true)).'.'.$this->logoFile->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->bannerFile && null === $this->logoFile) {
            return;
        } else {

            if(null !== $this->logoFile) {
                $this->logoFile->move($this->getUploadRootDir(), $this->logoFile->getClientOriginalName());
                $this->logo = $this->getUploadDir().'/'.$this->logoFile->getClientOriginalName();
                $this->logoFile = null;
            }

            if(null !== $this->bannerFile) {
                $this->bannerFile->move($this->getUploadRootDir(), $this->bannerFile->getClientOriginalName());
                $this->banner = $this->getUploadDir().'/'.$this->bannerFile->getClientOriginalName();
                $this->bannerFile = null;
            }
        }
    }

    /**
     * Set classification
     *
     * @param array $classification
     *
     * @return Game
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return array
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set banner
     *
     * @param string $banner
     *
     * @return Game
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set trailer
     *
     * @param string $trailer
     *
     * @return Game
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return string
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Game
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
}

