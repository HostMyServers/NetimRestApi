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
     * @var int|string|null
     */
    protected int|string|null $apiErrorCode;

    /**
     * Données supplémentaires retournées par l'API Netim.
     *
     * @var array|null
     */
    protected ?array $apiErrorData;

    /**
     * Constructeur de la classe NetimException.
     *
     * L'API rend des codes d'erreur textuels (« ZONE_LOCKED ») autant que numériques, et
     * « data » en objet quand la réponse est décodée en objet : les deux sont acceptés tels
     * qu'ils arrivent, sans quoi la construction lèverait une TypeError à la place de
     * l'exception attendue, et les catch (\Exception) des appelants la laisseraient passer.
     *
     * @param string         $message      Le message d'erreur.
     * @param int|string|null $apiErrorCode Le code d'erreur retourné par l'API Netim.
     * @param mixed          $apiErrorData Données supplémentaires associées à l'erreur.
     * @param int            $code         Le code d'erreur PHP (par défaut 0).
     * @param Throwable|null $previous     Exception précédente pour le chaînage d'exceptions.
     */
    public function __construct(
        string $message,
        int|string|null $apiErrorCode = null,
        mixed $apiErrorData = null,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->apiErrorCode = $apiErrorCode;
        $this->apiErrorData = self::asArray($apiErrorData);
    }

    /**
     * Récupère le code d'erreur retourné par l'API Netim.
     *
     * @return int|string|null Le code d'erreur de l'API Netim, ou null s'il n'est pas défini.
     */
    public function getApiErrorCode(): int|string|null
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

    /**
     * Un objet décodé devient un tableau associatif de bout en bout ; une valeur scalaire
     * est gardée sous « value » plutôt que perdue.
     */
    private static function asArray(mixed $data): ?array
    {
        if ($data === null) {
            return null;
        }

        if (is_array($data)) {
            return $data;
        }

        if (is_object($data)) {
            $decoded = json_decode((string) json_encode($data), true);

            return is_array($decoded) ? $decoded : ['value' => $data];
        }

        return ['value' => $data];
    }
}
