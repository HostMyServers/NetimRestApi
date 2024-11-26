<?php

namespace HostMyServers\NetimRestApi\Exceptions;

use Exception;
use Throwable;

/**
 * Exception personnalisée pour gérer les erreurs de l'API Netim.
 * Fournit des informations détaillées sur les erreurs survenues lors des requêtes API.
 */
class NetimException extends Exception
{
    /**
     * Code d'erreur retourné par l'API Netim.
     *
     * @var int|null
     */
    protected ?int $apiErrorCode;

    /**
     * Données supplémentaires retournées par l'API Netim.
     *
     * @var array|null
     */
    protected ?array $apiErrorData;

    /**
     * Constructeur de la classe NetimException.
     *
     * @param string         $message      Le message d'erreur.
     * @param int|null       $apiErrorCode Le code d'erreur retourné par l'API Netim.
     * @param array|null     $apiErrorData Données supplémentaires associées à l'erreur.
     * @param int            $code         Le code d'erreur PHP (par défaut 0).
     * @param Throwable|null $previous     Exception précédente pour le chaînage d'exceptions.
     */
    public function __construct(
        string $message,
        ?int $apiErrorCode = null,
        ?array $apiErrorData = null,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->apiErrorCode = $apiErrorCode;
        $this->apiErrorData = $apiErrorData;
    }

    /**
     * Récupère le code d'erreur retourné par l'API Netim.
     *
     * @return int|null Le code d'erreur de l'API Netim, ou null s'il n'est pas défini.
     */
    public function getApiErrorCode(): ?int
    {
        return $this->apiErrorCode;
    }

    /**
     * Récupère les données supplémentaires associées à l'erreur de l'API Netim.
     *
     * @return array|null Les données supplémentaires de l'erreur, ou null si non définies.
     */
    public function getApiErrorData(): ?array
    {
        return $this->apiErrorData;
    }

    /**
     * Convertit l'exception en chaîne de caractères pour une meilleure lisibilité.
     *
     * @return string Représentation textuelle de l'exception.
     */
    public function __toString(): string
    {
        $output = parent::__toString();
        if ($this->apiErrorCode !== null) {
            $output .= "\nAPI Error Code: " . $this->apiErrorCode;
        }
        if ($this->apiErrorData !== null) {
            $output .= "\nAPI Error Data: " . json_encode($this->apiErrorData);
        }
        return $output;
    }
}

