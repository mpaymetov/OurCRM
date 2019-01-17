import React, {Component} from 'react';
import {Link, BrowserRouter, BrowserRouter as Router, Route} from 'react-router-dom';

class DeleteButton extends Component {

    render() {
        return (
            <div className={"btn btn_delete"}>
                <Link to={this.props.buttonInfo.path}> {this.props.buttonInfo.buttonName} </Link>
            </div>
        );
    }

}

export default DeleteButton;