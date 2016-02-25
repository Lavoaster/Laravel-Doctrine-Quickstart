<?php

namespace App\Domain\Entities\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;


/**
 * @ORM\Entity()
 */
class Scope
{
    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string",length=40)
     * @ORM\GeneratedValue(strategy="NONE")
     * @var string
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="Grant",mappedBy="scopes")
     * @var ArrayCollection|Scope[]
     */
    protected $grants;
}
