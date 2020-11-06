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
        Choose your InstaFeed from the list:
      </p>
      <div className="MyAutocomplete__content">
        <input
          id={inputId}
          value={inputValue}
          onChange={handleChange}
          onFocus={() => setShowList(true)}
        />
        {showList && (
          <div className="MyAutocomplete__content__body">
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
                      <img className="MyAutocomplete__content__li__avatar" src={ _.get(item, 'info.profilePicture')} alt={ _.get(item, 'info.userName')}/>
                      {item.label}
                    </li>
                  );
                })
              )}
            </ul>
            <span
                onClick={() => setShowList(false)}
                className="MyAutocomplete__content__closeBtn"
              >
              <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg>
              </span>
          </div>
        )}
      </div>
    </div>
  );
};
export default MyAutocomplete;
