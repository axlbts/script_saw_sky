<?php

class Hotel
{
    private $host = 'mysql:host=localhost;dbname=coursBD';
    private $user = 'root';
    private $pass = '';

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass)
    {
        $this->pass = $pass;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user)
    {
        $this->user = $user;
    }
}
