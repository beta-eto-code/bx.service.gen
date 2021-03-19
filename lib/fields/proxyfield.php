<?php


namespace Bx\Service\Gen\Fields;


use Bx\Service\Gen\Interfaces\FieldInterface;
use Bx\Service\Gen\Interfaces\RequestDataSetterInterface;
use Bx\Service\Gen\Interfaces\SchemaInterface;
use Bx\Service\Gen\Interfaces\RequestDataInterface;

class ProxyField implements FieldInterface, RequestDataSetterInterface
{
    /**
     * @var FieldInterface
     */
    private $field;
    /**
     * @var string|null
     */
    private $source;
    /**
     * @var RequestDataInterface
     */
    private $requestData;

    public function __construct(FieldInterface $field, string $source = null)
    {
        $this->field = $field;
        $this->source = $source;
    }

    public function setRequestData(RequestDataInterface $requestData)
    {
        $this->requestData = $requestData;
    }

    public function getOriginalField(): FieldInterface
    {
        return $this->field;
    }

    public function getValue()
    {
        if (!empty($this->source) && $this->requestData instanceof RequestDataInterface) {
            $value = $this->requestData->getValueByKey($this->source);
            if (!is_null($value)) {
                return $value;
            }
        }

        return $this->field->getValue();
    }

    public function getType(): string
    {
        return $this->field->getType();
    }

    public function getName(): string
    {
        return $this->field->getName();
    }

    public function getParent(): ?SchemaInterface
    {
        return $this->field->getParent();
    }

    public function setParent(SchemaInterface $schema)
    {
        $this->field->setParent($schema);
    }
}