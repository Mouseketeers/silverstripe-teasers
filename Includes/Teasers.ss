<% if Teasers %>
<div id="Teasers">
	<% control Teasers %>
	<div class="teaser">
		<% if Title || Content %>
		<div class="teaserBody">
			<% if Title %><h4>$Title</h4><% end_if %>
			<% if Content %>$Content<% end_if %>
			<% if Link && LinkTitle %><p><a href="$Link.URLSegment" class="readMore">$LinkTitle</a></p><% end_if %>
		</div>
		<% end_if %>
		<% if Image %><div class="teaserImage">$Image.SetWidth(300)</div><% end_if %>
	</div>
	<% end_control %>
</div>
<% end_if %>