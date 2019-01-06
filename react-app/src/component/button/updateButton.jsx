import React, {Component} from 'react';

class UpdateButton extends Component {

    render() {
        return(
                <a href={this.props.buttonInfo.address} className="btn btn-primary">{this.props.buttonInfo.buttonName}</a>
        );
    }

}

export default UpdateButton;