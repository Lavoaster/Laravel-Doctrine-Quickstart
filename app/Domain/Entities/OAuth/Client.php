<?php

namespace App\Domain\Entities\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;


/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"id", "secret"}),
 *     @ORM\UniqueConstraint(columns={"name"}),
 * })
 */
class Client
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
    protected $secret;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="ClientEndpoint",mappedBy="client")
     * @var ClientEndpoint
     */
    protected $endpoints;

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="client_scopes")
     * @var ArrayCollection|Scope[]
     */
    protected $scopes;

    /**
     * @ORM\ManyToMany(targetEntity="Grant")
     * @ORM\JoinTable(name="client_grants")
     * @var ArrayCollection|Grant[]
     */
    protected $grants;
}
