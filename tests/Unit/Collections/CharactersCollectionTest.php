<?php

namespace Tests\Unit\Collections;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CharactersCollectionTest extends TestCase
{
    #[Test]
    public function check_character_collection_returned_in_correct_format(): void
    {
         // This method/data should not be changed
        $characters = [
            [
                'name' => 'Aloy',
                'damage' => 72,
                'skills' => ['archery', 'machine override', 'tracking'],
                'tribe' => 'Nora',
                'region' => ['name' => 'Embrace'],
                'weapons' => ['Hunter Bow', 'Spear'],
                'is_injured' => false
            ],
            [
                'name' => 'Varl',
                'damage' => 66,
                'skills' => ['tracking', 'melee combat'],
                'tribe' => 'Nora',
                'region' => ['name' => 'Sacred Lands'],
                'weapons' => ['Spear', 'Tripcaster'],
                'is_injured' => false
            ],
            [
                'name' => 'Kotallo',
                'damage' => 88,
                'skills' => ['swordplay', 'discipline'],
                'tribe' => 'Tenakth',
                'region' => ['name' => 'Lowland Territory'],
                'weapons' => ['Shredder Gauntlet'],
                'is_injured' => false
            ],
            [
                'name' => 'Hekarro',
                'damage' => 92,
                'skills' => ['leadership', 'strategy'],
                'tribe' => 'Tenakth',
                'region' => ['name' => 'Scalding Spear'],
                'weapons' => ['Warrior Bow'],
                'is_injured' => true
            ],
            [
                'name' => 'Zo',
                'damage' => 42,
                'skills' => ['healing', 'diplomacy'],
                'tribe' => 'Utaru',
                'region' => ['name' => 'Plainsong'],
                'weapons' => ['Healing Staff'],
                'is_injured' => false
            ],
            [
                'name' => 'Sayna',
                'damage' => 48,
                'skills' => ['medicine', 'botany'],
                'tribe' => 'Utaru',
                'region' => ['name' => 'Plainsong'],
                'weapons' => ['Root Sling'],
                'is_injured' => false
            ],
            [
                'name' => 'Alva',
                'damage' => 59,
                'skills' => ['data recovery', 'navigation'],
                'tribe' => 'Quen',
                'region' => ['name' => "Legacy's Landfall"],
                'weapons' => ['Focus Blade'],
                'is_injured' => false
            ],
            [
                'name' => 'Bojei',
                'damage' => 64,
                'skills' => ['scanning', 'archive diving'],
                'tribe' => 'Quen',
                'region' => ['name' => "Legacy's Landfall"],
                'weapons' => ['Shard Thrower'],
                'is_injured' => false
            ],
            [
                'name' => 'Beta',
                'damage' => 33,
                'skills' => ['focus hacking', 'tech analysis'],
                'tribe' => 'None',
                'region' => ['name' => 'The Base'],
                'weapons' => ['None'],
                'is_injured' => false
            ],
            [
                'name' => 'Sylenna',
                'damage' => 41,
                'skills' => ['hacking', 'energy manipulation'],
                'tribe' => 'None',
                'region' => ['name' => 'The Base'],
                'weapons' => ['Energy Pistol'],
                'is_injured' => false
            ],
            [
                'name' => 'Erend',
                'damage' => 81,
                'skills' => ['hammer combat', 'loyalty'],
                'tribe' => 'Oseram',
                'region' => ['name' => 'Chainscrape'],
                'weapons' => ['Hammer'],
                'is_injured' => false
            ],
            [
                'name' => 'Delah',
                'damage' => 75,
                'skills' => ['mining', 'trap setting'],
                'tribe' => 'Oseram',
                'region' => ['name' => 'Rockreach'],
                'weapons' => ['Explosive Slingshot'],
                'is_injured' => true
            ],
        ];

        $tribes = [
            'Nora' => [
                'members' => ['Aloy', 'Varl'],
                'skills' => ['archery', 'machine override', 'melee combat', 'tracking'],
                'regions' => ['Embrace', 'Sacred Lands'],
                'weapons' => ['Hunter Bow', 'Spear', 'Tripcaster'],
                'damage' => [
                    'min' => 66,
                    'max' => 72,
                    'average' => 69.0
                ],
            ],
            'Tenakth' => [
                'members' => ['Kotallo'],
                'skills' => ['discipline', 'swordplay'],
                'regions' => ['Lowland Territory'],
                'weapons' => ['Shredder Gauntlet'],
                'damage' => [
                    'min' => 88,
                    'max' => 88,
                    'average' => 88.0
                ],
            ],
            'Utaru' => [
                'members' => ['Sayna', 'Zo'],
                'skills' => ['botany', 'diplomacy', 'healing', 'medicine'],
                'regions' => ['Plainsong'],
                'weapons' => ['Healing Staff', 'Root Sling'],
                'damage' => [
                    'min' => 42,
                    'max' => 48,
                    'average' => 45.0
                ],
            ],
            'Quen' => [
                'members' => ['Alva', 'Bojei'],
                'skills' => ['archive diving', 'data recovery', 'navigation', 'scanning'],
                'regions' => ["Legacy's Landfall"],
                'weapons' => ['Focus Blade', 'Shard Thrower'],
                'damage' => [
                    'min' => 59,
                    'max' => 64,
                    'average' => 61.5
                ],
            ],
            'None' => [
                'members' => ['Beta', 'Sylenna'],
                'skills' => ['energy manipulation', 'focus hacking', 'hacking', 'tech analysis'],
                'regions' => ['The Base'],
                'weapons' => ['Energy Pistol', 'None'],
                'damage' => [
                    'min' => 33,
                    'max' => 41,
                    'average' => 37.0
                ],
            ],
            'Oseram' => [
                'members' => ['Erend'],
                'skills' => ['hammer combat', 'loyalty'],
                'regions' => ['Chainscrape'],
                'weapons' => ['Hammer'],
                'damage' => [
                    'min' => 81,
                    'max' => 81,
                    'average' => 81.0
                ],
            ],
        ];

        $this->assertEquals($tribes, $this->groupByTribe($characters));
    }

    private function groupByTribe(array $characters)
    {
        return collect($characters)->where('is_injured', false)
            ->groupBy('tribe')
            ->map(function($charactersInTribe) {
            
                $damage = $charactersInTribe->pluck('damage');

                return [
                    'members' => $charactersInTribe->pluck('name')
                        ->sort()
                        ->values()
                        ->all(),
                    'skills' => $charactersInTribe->pluck('skills')
                        ->flatten()
                        ->unique()
                        ->sort()
                        ->values()
                        ->all(),
                    'regions' => $charactersInTribe->pluck('region.name')
                        ->unique()
                        ->sort()
                        ->all(),
                    'weapons' => $charactersInTribe->pluck('weapons')
                        ->flatten()
                        ->unique()
                        ->sort()
                        ->values()
                        ->all(),
                    'damage' => [
                        'min'     => $damage->min(),
                        'max'     => $damage->max(),
                        'average' => round($damage->avg(), 1),
                    ],
                ];
            })->toArray();
    }
}
