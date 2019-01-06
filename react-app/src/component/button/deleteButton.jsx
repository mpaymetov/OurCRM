import React, {Component} from 'react';

class DeleteButton extends Component {

    render() {
        return(
                <a href={this.props.buttonInfo.address} className="btn btn-danger">{this.props.buttonInfo.buttonName}</a>
        );
    }

}

export default DeleteButton;