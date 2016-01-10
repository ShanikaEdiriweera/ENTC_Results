<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semester2
 *
 * @ORM\Table(name="semester2")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Semester2Repository")
 */
class Semester2
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="s_id", type="string", length=7, unique=true)
     */
    private $sId;

    /**
     * @var string
     *
     * @ORM\Column(name="GPA", type="decimal", precision=5, scale=4)
     */
    private $gPA;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sId
     *
     * @param string $sId
     *
     * @return Semester2
     */
    public function setSId($sId)
    {
        $this->sId = $sId;

        return $this;
    }

    /**
     * Get sId
     *
     * @return string
     */
    public function getSId()
    {
        return $this->sId;
    }

    /**
     * Set gPA
     *
     * @param string $gPA
     *
     * @return Semester2
     */
    public function setGPA($gPA)
    {
        $this->gPA = $gPA;

        return $this;
    }

    /**
     * Get gPA
     *
     * @return string
     */
    public function getGPA()
    {
        return $this->gPA;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return Semester2
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }
}

