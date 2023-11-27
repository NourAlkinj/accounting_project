<?php

namespace React\Promise;

/**
 * @template T
 */
final class Deferred
{
    /**
     * @var PromiseInterface<T>
     */
    private $promise;

<<<<<<< HEAD
    /** @var callable */
    private $resolveCallback;

    /** @var callable */
    private $rejectCallback;

=======
    /** @var callable(T):void */
    private $resolveCallback;

    /** @var callable(\Throwable):void */
    private $rejectCallback;

    /**
     * @param (callable(callable(T):void,callable(\Throwable):void):void)|null $canceller
     */
>>>>>>> 06408f47f14cbeb88ea760bb11bed2d42158fc64
    public function __construct(callable $canceller = null)
    {
        $this->promise = new Promise(function ($resolve, $reject): void {
            $this->resolveCallback = $resolve;
            $this->rejectCallback  = $reject;
        }, $canceller);
    }

    /**
     * @return PromiseInterface<T>
     */
    public function promise(): PromiseInterface
    {
        return $this->promise;
    }

    /**
     * @param T $value
     */
    public function resolve($value): void
    {
        ($this->resolveCallback)($value);
    }

    public function reject(\Throwable $reason): void
    {
        ($this->rejectCallback)($reason);
    }
}
