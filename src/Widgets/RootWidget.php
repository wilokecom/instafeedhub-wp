<?php

namespace InstafeedHub\Widgets;

/**
 * Class RootWidget
 * @package InstafeedHub\Widgets
 */
class RootWidget extends \WP_Widget
{
	/**
	 * @param $aFields
	 * @param $aInstance
	 */
	protected function render($aFields, $aInstance)
	{
		foreach ($aFields as $fieldKey => $aArgs) {
			if (!isset($aInstance[$fieldKey]) && isset($aArgs['value'])) {
				$aInstance[$fieldKey] = $aArgs['value'];
			}

			switch ($aArgs['type']) {
				case 'select':
					$this->selectField($fieldKey, $aInstance, $aArgs);
					break;
				case 'textarea':
					$this->textareaField($fieldKey, $aInstance, $aArgs);
					break;
				case'button':
					$this->buttonField($fieldKey, $aInstance, $aArgs);
					break;
				default:
					$this->inputField($fieldKey, $aInstance, $aArgs);
					break;
			}
		}
	}

	/**
	 * @param $fieldKey
	 * @param $aInstance
	 * @param $aArgs
	 */
	protected function inputField($fieldKey, $aInstance, $aArgs)
	{
		?>
        <div class="field-item" style="margin-top: 20px">
            <label for="<?php echo $this->get_field_id($fieldKey); ?>"><?php echo esc_html($aArgs['name']); ?></label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name($fieldKey); ?>" id="<?php echo
			$this->get_field_id($fieldKey); ?>" value="<?php echo esc_attr($this->getValue($fieldKey, $aInstance)); ?>">
			<?php echo $this->printDesc($aArgs); ?>
        </div>
		<?php
	}

	/***
	 * @param $fieldKey
	 * @param $aInstance
	 * @param $aArgs
	 */
	protected function textareaField($fieldKey, $aInstance, $aArgs)
	{
		?>
        <div class="field-item" style="margin-top: 20px">
            <label for="<?php echo $this->get_field_id($fieldKey); ?>"><?php echo esc_html($aArgs['name']); ?></label>
            <textarea class="widefat" name="<?php echo $this->get_field_name($fieldKey); ?>" id="<?php echo
			$this->get_field_id($fieldKey); ?>"><?php echo esc_attr($this->getValue($fieldKey, $aInstance)); ?></textarea>
			<?php echo $this->printDesc($aArgs); ?>
        </div>
		<?php
	}


	/**
	 * @param $fieldKey
	 * @param $aInstance
	 * @param $aArgs
	 */
	protected function selectField($fieldKey, $aInstance, $aArgs)
	{
		$val = $this->getValue($fieldKey, $aInstance);
		?>
        <div class="field-item" style="margin-top: 20px">
            <label for="<?php echo $this->get_field_id($fieldKey); ?>"><?php echo esc_html($aArgs['name']); ?></label>
            <select name="<?php echo $this->get_field_name($fieldKey); ?>" id="<?php echo
			$this->get_field_id($fieldKey); ?>" class="widefat">
				<?php foreach ($aArgs['options'] as $optKey => $optName) : ?>
                    <option
						<?php selected($optKey, $val); ?>
                            value="<?php echo esc_attr($optKey); ?>">
						<?php echo esc_html($optName); ?>
                    </option>
				<?php endforeach; ?>
            </select>
			<?php echo $this->printDesc($aArgs); ?>
        </div>
		<?php
	}

	/**
	 * @param $fieldKey
	 * @param $aInstance
	 * @param $aArgs
	 */
	protected function buttonField($fieldKey, $aInstance, $aArgs)
	{
		?>
        <div class="field-item" style="margin-top: 20px">
            <button class="widefat" name="<?php echo $this->get_field_name($fieldKey); ?>" id="<?php echo
			$this->get_field_id($fieldKey); ?>"><?php echo esc_html__($aArgs['name']); ?></button>
			<?php echo $this->printDesc($aArgs); ?>
        </div>
		<?php
	}

	/**
	 * @param $aInstance
	 * @param $fieldKey
	 *
	 * @return string
	 */
	protected function getValue($fieldKey, $aInstance)
	{
		return isset($aInstance[$fieldKey]) ? $aInstance[$fieldKey] : '';
	}

	/**
	 * @param $aNewInstance
	 * @param $aOldInstance
	 * @return mixed
	 */
	protected function updateValues($aNewInstance, $aOldInstance)
	{
		$aInstance = $aOldInstance;
		foreach ($aNewInstance as $key => $val) {
			$aInstance[$key] = strip_tags($val);
		}

		return $aInstance;
	}

	/**
	 * @param $aFields
	 */
	protected function printDesc($aFields)
	{
		if (isset($aFields['desc']) && !empty($aFields['desc'])) {
			echo '<p>' . esc_html__($aFields['desc'], 'wiloke-instafeedhub-wp') . '</p>';
		}
	}
}
