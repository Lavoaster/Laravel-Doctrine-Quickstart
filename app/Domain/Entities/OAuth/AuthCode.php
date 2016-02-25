<?php

namespace App\Domain\Entities\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;


/**
 * @ORM\Entity()
 */
class AuthCode
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
     * @ORM\OneToMany(targetEntity="Session",mappedBy="authCodes")
     * @var Session
     */
    protected $session;

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="auth_code_scopes")
     * @var ArrayCollection|Scope[]
     */
    protected $scopes;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $redirectUri;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $expireTime;
}
