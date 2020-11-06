import { useState } from "react";
import { Button, Modal } from '@wordpress/components'; 

const MyModal = ({onCloseModal, children}) => {

    return (
        <div className="wilMyModal">
            <Modal onRequestClose={ onCloseModal } overlayClassName="wilMyModal__overlay" shouldCloseOnClickOutside={false}>
              { children }
            </Modal>
        </div>
    )
}

export default MyModal;