import React, { Component } from 'react';

class Select extends Component {
	constructor(props) {
		super(props);

		this.state = {
			isShow: false
		};
	}

	handleChoose(value) {
		this.setState({
			isShow: false
		}, () => {
			this.props.onChange(value);
		});
	}

	render() {
		let options = this.props.options.map(item => {
			return (
				<div className="option" onClick={() => handleChoose(item)}>{item}</div>
			);
		});

		return (
			<div className="select">
                <input
                	value={this.props.value}
                	className="select_box"
                	onClick={() => this.setState({isShow: !this.state.isShow})}
                	type="text" />
                <span className="select-arrow"></span>
                <div className="select_options" data-for="pay-method">
                    {options}
                </div>
            </div>
		);
	}
}

export default Select;