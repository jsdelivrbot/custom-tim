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

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 * @ORM\Table(name="tim_zone")
 * @UniqueEntity("label")
 */

class Zone  implements \Serializable
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
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Zone
     */
    public function setLabel(string $label): Zone
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Zone
     */
    public function setDescription(string $description): Zone
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->label, $this->description]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->label, $this->description] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
