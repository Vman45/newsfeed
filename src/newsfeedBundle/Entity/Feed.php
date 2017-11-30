<?php

namespace newsfeedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="feed")
 * @ORM\Entity
 */
class Feed
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=240, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string", length=240, nullable=true)
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=45, nullable=true)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

