import React, {Component} from 'react';

class CloseButton extends Component {

    render() {
        return(
            <a href={this.props.buttonInfo.path} className="btn btn-success">{this.props.buttonInfo.buttonName}</a>
        );
    }

}

export default CloseButton;