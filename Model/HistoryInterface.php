<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/10/16
 * Time: 09:52
 */

namespace Miky\Bundle\UserBundle\Model;


interface HistoryInterface
{
    const TYPE_AD = 0;
    const TYPE_PROFILE = 1;
    const TYPE_STORE = 2;
}