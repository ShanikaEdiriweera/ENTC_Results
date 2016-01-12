<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semester_results
 *
 * @ORM\Table(name="semester_results")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Semester_resultsRepository")
 */
class Semester_results
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
     * @var int
     *
     * @ORM\Column(name="sem_id", type="integer")
     */
    private $semId;

    /**
     * @var int
     *
     * @ORM\Column(name="stu_id", type="integer")
     */
    private $stuId;

    /**
     * @var string
     *
     * @ORM\Column(name="GPA", type="decimal", precision=5, scale=4, nullable=true)
     */
    private $gPA;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
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
     * Set semId
     *
     * @param integer $semId
     *
     * @return Semester_results
     */
    public function setSemId($semId)
    {
        $this->semId = $semId;

        return $this;
    }

    /**
     * Get semId
     *
     * @return int
     */
    public function getSemId()
    {
        return $this->semId;
    }

    /**
     * Set stuId
     *
     * @param integer $stuId
     *
     * @return Semester_results
     */
    public function setStuId($stuId)
    {
        $this->stuId = $stuId;

        return $this;
    }

    /**
     * Get stuId
     *
     * @return int
     */
    public function getStuId()
    {
        return $this->stuId;
    }

    /**
     * Set gPA
     *
     * @param string $gPA
     *
     * @return Semester_results
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
     * @return Semester_results
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

