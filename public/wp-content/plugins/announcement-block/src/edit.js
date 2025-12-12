// Imports WordPress block editor and UI components
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, DateTimePicker } from '@wordpress/components';
import './editor.scss';

//This is the main function that renders the block’s editor UI in the block editor.
export default function Edit({ attributes, setAttributes }) {


	const blockProps = useBlockProps();

	// Destructure attributes
	const { show, hideAfterDateTime, content, useExpiryDate, showFromDateTime, useStartDate } = attributes;

 // Data Time logic
	const safeShowFromDateTime = useStartDate ? (showFromDateTime || null) : null;

	// Handlers for updating attributes UI Controls
	const onShowFromDateChange = (value) => {
		setAttributes({ showFromDateTime: value });
	};

	const onToggleShow = (value) => {
		setAttributes({
			show: value,
			hideAfterDateTime: '',
			useExpiryDate: false,
			showFromDateTime: '',
			useStartDate: false,
		});
	};

	const onToggleUseStartDate = (value) => {
		setAttributes({
			useStartDate: value,
			showFromDateTime: value ? showFromDateTime : '',
		});
	};

	const onDateTimeChange = (value) => {
		setAttributes({ hideAfterDateTime: value });
	};

	const onChangeContent = (newContent) => {
		setAttributes({ content: newContent })
	}

	const onToggleUseExpiryDate = (value) => {
		setAttributes({ useExpiryDate: value });
		if (!value) {
			// Clear the date if the toggle is turned off
			setAttributes({ hideAfterDateTime: '' });
		}
	};

	// Update isHidden logic to consider showFromDateTime
	const now = new Date();
	const showFrom = useStartDate && showFromDateTime ? new Date(showFromDateTime) : null;
	const hideAfter = hideAfterDateTime ? new Date(hideAfterDateTime) : null;
	const isHidden =
		!show ||
		(showFrom && now < showFrom) ||
		(useExpiryDate && hideAfter && now > hideAfter);

	const isHiddenClass = isHidden ? 'aptex-announcement-is-hidden' : '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Announcement Settings', 'aptex-announcement')} initialOpen={true}>
					<ToggleControl
						label={__('Show Announcement', 'aptex-announcement')}
						checked={show}
						onChange={onToggleShow}
					/>
					{show && <>
						<ToggleControl
							label={__('Automatic Expiration', 'aptex-announcement')}
							checked={useExpiryDate}
							onChange={onToggleUseExpiryDate}
						/>
						{useExpiryDate && (
							<DateTimePicker
								label={__('Hide After Date', 'aptex-announcement')}
								currentDate={hideAfterDateTime}
								onChange={onDateTimeChange}
								is12Hour={false}
							/>
						)}
						<ToggleControl
							label={__('Schedule Start Date', 'aptex-announcement')}
							checked={useStartDate}
							onChange={onToggleUseStartDate}
						/>
						{useStartDate && (
							<DateTimePicker
								label={__('Show From Date', 'aptex-announcement')}
								currentDate={safeShowFromDateTime}
								onChange={onShowFromDateChange}
								is12Hour={false}
							/>
						)}
					</>}
				</PanelBody>
			</InspectorControls>
			<div className={isHiddenClass}>
				{isHidden && <><div className='aptex-disabled'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" className="aptex-icon--disabled"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg> {__('hidden', 'aptex-announcement')}</div></>}
				<RichText
					identifier="content"
					tagName="p"
					{...blockProps}
					value={content}
					onChange={onChangeContent}
					placeholder={__('Write your announcement here...', 'aptex-announcement')}
				/>
			</div>
		</>
	);
}
