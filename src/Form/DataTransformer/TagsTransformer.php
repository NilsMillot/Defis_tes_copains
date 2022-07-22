<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use App\Entity\Tags;
use Doctrine\ORM\EntityManagerInterface;

class TagsTransformer implements DataTransformerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($value):string
    {
        return implode(',',$value);
    }


    public function reverseTransform($string):array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $string))));
        $tags = $this->entityManager
            ->getRepository(Tags::class)->findBy([
            'name' => $names
        ]);
        $newNames = array_diff($names, $tags);
        foreach ($newNames as $name) {
            $tag = new Tags();
            $tag->setName($name);
            $tags[] = $tag;
        }
        return $tags;
    }
}