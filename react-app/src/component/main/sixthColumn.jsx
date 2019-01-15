import React, {Component} from 'react';
import ItemPost from "./itemPost.jsx";


class SixColumn extends Component {
    constructor(props) {
        super(props);
        this.state = {column : this.props.column};

    }

    render() {
        console.log(" six state", this.props);
        if (this.state.column.info.allModels.length > 0) {
            return (
                <ItemPost column={this.state.column.info.allModels}/>
            );
        }
        return<p></p>;
    }
}

export default SixColumn;