<?php
/**
 * Created by PhpStorm.
 * User: sy_abdoulaye
 * Date: 30/03/2018
 * Time: 10:55
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 * @ORM\Table(name="tim_status")
 * @UniqueEntity("label")
 */

class Status  implements \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="status.blank_label")
     */
    private $label;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $label
     * @return Status
     */
    public function setLabel(string $label): Status
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel():? string
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->label]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->label] = unserialize($serialized, ['allowed_classes' => false]);
    }
}