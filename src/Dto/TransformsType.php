<?php
/**
 * DsigSdk    the PHP XML Digital Signature recommendation SDK,
 *            source http://www.w3.org/2000/09/xmldsig#
 *
 * This file is a part of DsigSdk.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2019-2022 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      https://kigkonsult.se
 * @license   Subject matter of licence is the software DsigSdk.
 *            The above copyright, link, package and version notices,
 *            this licence notice shall be included in all copies or substantial
 *            portions of the DsigSdk.
 *
 *            DsigSdk is free software: you can redistribute it and/or modify
 *            it under the terms of the GNU Lesser General Public License as published
 *            by the Free Software Foundation, either version 3 of the License,
 *            or (at your option) any later version.
 *
 *            DsigSdk is distributed in the hope that it will be useful,
 *            but WITHOUT ANY WARRANTY; without even the implied warranty of
 *            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *            GNU Lesser General Public License for more details.
 *
 *            You should have received a copy of the GNU Lesser General Public License
 *            along with DsigSdk. If not, see <https://www.gnu.org/licenses/>.
 */
declare( strict_types = 1 );
namespace Kigkonsult\DsigSdk\Dto;

/**
 * Class TransformsType
 */
class TransformsType extends DsigBase
{
    /**
     * @var Transform[]
     */
    protected array $transform = [];

    /**
     * Factory method with one transform
     *
     * @param Transform $transform
     * @return static
     */
    public static function factoryTransform( Transform $transform ) : static
    {
        return self::factory()->addTransform( $transform );
    }

    /**
     * Factory method with one transform, algorithm only
     *
     * @param string $algorithm
     * @return static
     */
    public static function factoryTransformAlgorithm( string $algorithm ) : static
    {
        return self::factory()->addTransformAlgorithm( $algorithm );
    }

    /**
     * @return Transform[]
     */
    public function getTransform() : array
    {
        return $this->transform;
    }

    /**
     * Return bool true if transform is not empty
     *
     * @return bool
     */
    public function isTransformSet() : bool
    {
        return ! empty( $this->transform );
    }

    /**
     * @param Transform $transform
     * @return static
     */
    public function addTransform( Transform $transform ) : static
    {
        $this->transform[] = $transform;
        return $this;
    }

    /**
     * @param string $algorithm
     * @return static
     */
    public function addTransformAlgorithm( string $algorithm ) : static
    {
        $this->transform[] = Transform::factoryAlgorithm( $algorithm );
        return $this;
    }

    /**
     * @param Transform[] $transform
     * @return static
     */
    public function setTransform( array $transform ) : static
    {
        foreach( $transform as $tForm ) {
            $this->addTransform( $tForm );
        }
        return $this;
    }
}
