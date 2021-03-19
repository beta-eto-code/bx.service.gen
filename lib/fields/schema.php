<?php


namespace Bx\Service\Gen\Fields;


use Bx\Service\Gen\Interfaces\FieldInterface;
use Bx\Service\Gen\Interfaces\RequestDataInterface;
use Bx\Service\Gen\Interfaces\RequestDataSetterInterface;
use Bx\Service\Gen\Interfaces\SchemaInterface;
use Faker\Generator;

class Schema extends BaseField implements SchemaInterface
{
    /**
     * @var RequestDataInterface
     */
    private $requestData;

    public function __construct(Generator $generator, string $name = null)
    {
        parent::__construct($generator, $name ?? '');
    }

    public function setRequestData(RequestDataInterface $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @var array
     */
    private $fields;

    /**
     * @return array
     */
    public function getValue()
    {
        $result = [];
        foreach ($this->getChildList() as $filed) {
            if ($this->requestData instanceof RequestDataInterface && $filed instanceof RequestDataSetterInterface) {
                $filed->setRequestData($this->requestData);
            }

            $name = $filed->getName();
            $value = $filed->getValue();
            $result[$name] = $value;
        }

        return $result;
    }

    public function getType(): string
    {
        return 'object';
    }

    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @return FieldInterface[]
     */
    public function getChildList(): array
    {
        return $this->fields ?? [];
    }

    /**
     * @param string $selector
     * @return FieldInterface|null
     */
    public function findField(string $selector): ?FieldInterface
    {
        $arSelector = explode('.', $selector);
        $currentFieldName = current($arSelector);
        if (empty($currentField)) {
            return null;
        }
        $nextSelector = implode('.', array_shift($arSelector));

        foreach ($this->getChildList() as $field) {
            if($field->getName() === $currentFieldName) {
                if (empty($nextSelector)) {
                    return $field;
                }

                if ($field instanceof SchemaInterface) {
                    $findField = $field->findField($nextSelector);
                    if ($findField instanceof FieldInterface) {
                        return $findField;
                    }
                }
            }
        }

        return null;
    }
}