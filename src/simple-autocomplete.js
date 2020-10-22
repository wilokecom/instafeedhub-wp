import * as _ from "lodash";
import { RichText } from "@wordpress/editor";
const { useState, useEffect } = wp.element;

const MyAutocomplete = ({
  id = "id",
  label,
  value,
  options,
  onChange,
  onSelectItem,
}) => {
  const [inputValue, setInputValue] = useState(value);
  const [itemSelected, setItemSlected] = useState({});
  const [showList, setShowList] = useState(false);
  const inputId = Math.random() + id + Date.now();

  useEffect(() => {
    setInputValue(value);
  }, [value]);

  const handleSelectUser = (item) => () => {
    onSelectItem(item);
    setItemSlected(item);
    setShowList(false);
  };

  const handleChange = (event) => {
    onChange(event.target.value);
    setInputValue(event.target.value);
    setShowList(true);
  };

  return (
    <div className="MyAutocomplete">
      <p className="MyAutocomplete__label">
        Choose your browser from the list:
      </p>
      <div className="MyAutocomplete__content">
        <input
          id={inputId}
          value={inputValue}
          onChange={handleChange}
          onFocus={() => setShowList(true)}
        />
        {showList && (
          <ul>
            {!options || _.isEmpty(options) ? (
              <li>Not foud user! Try agan.</li>
            ) : (
              options.map((item) => {
                const active = item.id === itemSelected.id;
                const CLASS = active ? "active" : "";
                return (
                  <li
                    className={`MyAutocomplete__content__li ${CLASS}`}
                    onClick={handleSelectUser(item)}
                  >
                    {item.name}
                  </li>
                );
              })
            )}
            <span
              onClick={() => setShowList(false)}
              className="MyAutocomplete__content__closeBtn"
            >
              close
            </span>
          </ul>
        )}
      </div>
    </div>
  );
};
export default MyAutocomplete;
