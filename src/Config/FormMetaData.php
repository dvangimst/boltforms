<?php

namespace Bolt\Extension\Bolt\BoltForms\Config;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Form meta data bag.
 *
 * NOTE: Parameter values must be serialisable.
 *
 * Copyright (c) 2014-2016 Gawain Lynch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Gawain Lynch <gawain.lynch@gmail.com>
 * @copyright Copyright (c) 2014-2016, Gawain Lynch
 * @license   http://opensource.org/licenses/GPL-3.0 GNU Public License 3.0
 */
class FormMetaData extends ParameterBag
{
    /** @var string */
    protected $_metaId;

    /**
     * Constructor.
     *
     * @param array  $parameters
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->_metaId = bin2hex(random_bytes(32));;
    }

    /**
     * @return string
     */
    public function getMetaId()
    {
        return $this->_metaId;
    }

    /**
     * @param string $metaId
     */
    public function setMetaId($metaId)
    {
        $this->_metaId = $metaId;
    }
}
