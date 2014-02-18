<?php

namespace Nucleus\Bundle\BinderBundle\VariableRegistry;

use Nucleus\Binder\IBinder;
use Nucleus\Binder\IVariableRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class SessionVariableRegistryAdapter implements IVariableRegistry
{
    /**
     * @var string
     */
    private $scope;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session, $scope = IBinder::DEFAULT_SCOPE)
    {
        $this->scope = $scope;
        $this->session = $session;
    }

    public function getScopeName()
    {
        return $this->scope;
    }

    public function get($name)
    {
        return $this->session->get($name);
    }

    public function set($name, $value)
    {
        $this->session->set($name,$value);
    }

    public function has($name)
    {
        return $this->session->has($name);
    }
}