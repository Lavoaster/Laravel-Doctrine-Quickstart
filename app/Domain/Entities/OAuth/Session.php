<?php

namespace App\Domain\Entities\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;


/**
 * @ORM\Entity()
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"client_id", "owner_type", "owner_id"})
 * }))
 */
class Session
{
    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @var Client
     */
    protected $client;

    /**
     * Possible types are user or client
     *
     * @ORM\Column(type="string",options={"default" = "user"})
     * @var string
     */
    protected $ownerType;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $ownerId;

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="session_scopes")
     * @var ArrayCollection|Scope[]
     */
    protected $scopes;
}
