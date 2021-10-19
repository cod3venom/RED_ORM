<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 11:58
*/

namespace src\test_models;

/**
 * @Table (name=USER_PROFILE);
 */
class UserProfile{
    /**
     * User profile id
     * @Column (name=ID, type=int, nullable=false);
     * @var int
     */
    protected int $id;

    /**
     * User profile email address
     * @Column (name=USER_EMAIL, type=string, nullable=false);
     * @var string
     */
    protected string $userEmail;
}